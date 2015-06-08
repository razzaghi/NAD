rm -rf ./web/media/product/*
#phprm -rf ./administrator/web/bower_components/
#rm -rf ./site/web/bower_components/

cd ./site/
bower install -f
cd ./../
cd ./administrator/
bower install -f