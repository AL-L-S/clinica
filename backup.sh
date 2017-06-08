#!/bin/bash
usuario=''

while [$usuario == '']; do
    usuario=$(whiptail --title "Usuario" --inputbox "Informe o nome de usuario dessa maquina (ex: sisprod ):" --default-item "sisprod" --fb 15 60 3>&1 1>&2 2>&3)
done

caminho="/home/$usuario/Dropbox"
aux="/home/$usuario/backupBanco"

if [ ! -d "$aux" ]; then
    mkdir $aux
fi

chmod 600 /home/$usuario/.pgpass

if [ ! -d "$caminho" ];
then
    echo
    tput setaf 1; tput bold;
    echo "++++++++++++++++++++++ ATENÇÃO ++++++++++++++++++++++"
    tput sgr0
    echo

    tput setaf 3
    echo 'O Dropbox Não está instalado nessa maquina. Para instalar acesse:'
    tput sgr0

    tput setaf 3; tput bold; tput smul;
    echo https://www.dropbox.com/install-linux
    tput rmul; tput sgr0;

    tput setaf 3
    echo "E baixe a versão para o ubuntu."
    echo "Abra o terminal e navegue até a pasta em que o arquivo foi baixado."
    echo 'Em seguida rode o comando:'
    tput sgr0

    tput setaf 2; tput bold; tput smul;
    echo "sudo dpkg -i dropbox_*.deb"
    tput sgr0

    tput setaf 3
    echo "Feito isso, abra o Dropbox, siga os passos de instalação e tente novamente."
    echo
    tput sgr0

    tput setaf 1; tput bold;
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++"
    tput sgr0
else

    resposta='S'
    indice=0

    while [ $resposta == 'S' ]
    do

        bancos[$indice]=$(whiptail --title "Nome do banco" --inputbox "Informe o nome do banco no postgres:" --fb 15 60 3>&1 1>&2 2>&3)

        pasta[$indice]=$(whiptail --title "Pasta do Dropbox" --inputbox "Informe o nome da pasta desse banco no Dropbox:" --fb 15 60 3>&1 1>&2 2>&3)

        if [ "${bancos[$indice]}" != '' ]; then
            if [ "${pasta[$indice]}" != '' ]; then
                if [ ! -d "$caminho/${pasta[$indice]}" ]; then
                    mkdir $caminho/${pasta[$indice]}
                fi

                if [ ! -d "$aux/${pasta[$indice]}" ]; then
                    mkdir $aux/${pasta[$indice]}
                fi

                let indice=$indice+1

            else
                whiptail --title “Erro” --msgbox "A Pasta não foi informada. Tente novamente!" 20 65 --scrolltext
            fi
        else
            whiptail --title “Erro” --msgbox "O Banco não foi informado. Tente novamente!" 20 65 --scrolltext
        fi

        if whiptail --title "Adicionar Bancos" --yesno "Deseja adicionar outro banco? " 10 50
        then
            resposta='S'
        else
            resposta='n'
        fi

    done

    echo
    tput setaf 1; tput bold;
    echo "ATENÇÃO! Não feche esse terminal."
    tput sgr0
    echo

    while true
    do
        i=0
        while [ $i -lt $indice ]
        do
            if [ "${bancos[$i]}" != '' ]; then
                if [ "${pasta[$i]}" != '' ]; then

                    horario=$(date '+%A %d-%m-%Y %H %M')
                    printf "Backup em andamento [${bancos[$i]} $horario]..."
                    /usr/bin/pg_dump --host=localhost --port=5432 --username="postgres" --format=c --blobs --file="$aux/${pasta[$i]}/${bancos[$i]} $horario.backup" --dbname="${bancos[$i]}" --no-password
                    printf " Terminado!\n"
                    mv "$aux/${pasta[$i]}/${bancos[$i]} $horario.backup" "$caminho/${pasta[$i]}/${bancos[$i]} $horario.backup"

                    qtdeArquivos=$(ls $caminho/${pasta[$i]}/ | wc -l)
                    if [ $qtdeArquivos -gt 3 ]
                    then
                        arqAntigo=$(ls -t $caminho/${pasta[$i]}/ | tail -1)
                        rm "$caminho/${pasta[$i]}/$arqAntigo"
                    fi

                    let i=$i+1
                fi
            fi
        done

                    sleep 30
    done
fi
