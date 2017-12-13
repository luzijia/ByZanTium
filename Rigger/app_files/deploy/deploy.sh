#!/bin/bash
cur_dir=`old=\`pwd\`; cd \`dirname $0\`; echo \`pwd\`; cd $old;`
env=$1

if [ -z "$env" ]; then
	echo "USAGE: $0 ENV"
	echo "    ENV: dev, online"
	exit 1
fi

deploy_dev()
{
	ln -sf $cur_dir/../config/config.dev.php $cur_dir/../config/config.php.tmp
    cd $cur_dir/../config/
    mv config.php.tmp config.php;
}

deploy_online()
{
	ln -sf $cur_dir/../config/config.prod.php $cur_dir/../config/config.php.tmp
    cd $cur_dir/../config/
    mv config.php.tmp config.php;
}

if [ "$env" = "online" ]; then
	deploy_online
else
	deploy_dev
fi
