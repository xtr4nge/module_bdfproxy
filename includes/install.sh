#!/bin/bash

echo "installing mitmproxy..."

apt-get -y install python-pip python-configobj

apt-get -y install build-essential python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev

pip install --upgrade six

#https://pypi.python.org/packages/source/u/urwid/urwid-1.3.0.tar.gz # if error, install urwid manually first. (http://urwid.org/)

pip install mitmproxy


echo "installing bdfproxy..."

git clone https://github.com/xtr4nge/BDFProxy bdf-proxy/
#git clone https://github.com/secretsquirrel/the-backdoor-factory bdf-proxy/

git clone https://github.com/xtr4nge/the-backdoor-factory bdf-proxy/bdf/
#git clone https://github.com/secretsquirrel/the-backdoor-factory bdf-proxy/bdf/

cd bdf-proxy/bdf/
./install.sh
cd ..
./install.sh
cd ..

echo "patching bdfproxy (AUTO_PATCH)..."

patch bdf-proxy/bdf_proxy.py < patch/bdf_proxy.py.patch
patch bdf-proxy/bdfproxy.cfg < patch/bdfproxy.cfg.patch
patch bdf-proxy/bdf/pebin.py < patch/pebin.py.patch

echo "..DONE.."
exit
