#!/bin/bash

echo "installing mitmproxy..."

apt-get -y install python-pip python-configobj

apt-get -y install build-essential python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev

# NEW: 2016-04-28
apt-get -y install gcc-4.9-multilib gcc-multilib lib32asan1 lib32atomic1 lib32cilkrts5 lib32gcc-4.9-dev lib32gcc1 lib32gomp1 lib32itm1 
apt-get -y install lib32quadmath0 lib32stdc++6 lib32ubsan0 libc6-dev-x32 libc6-i386 libc6-x32 libx32asan1 libx32atomic1 libx32cilkrts5 libx32gcc-4.9-dev 
apt-get -y install libx32gcc1 libx32gomp1 libx32itm1 libx32quadmath0 libx32ubsan0
# ----/.

pip install --upgrade six

#https://pypi.python.org/packages/source/u/urwid/urwid-1.3.0.tar.gz # if error, install urwid manually first. (http://urwid.org/)

pip install mitmproxy


echo "installing bdfproxy..."

git clone https://github.com/xtr4nge/BDFProxy bdf-proxy/
#git clone https://github.com/secretsquirrel/BDFProxy bdf-proxy/

git clone https://github.com/xtr4nge/the-backdoor-factory bdf-proxy/bdf/
#git clone https://github.com/secretsquirrel/the-backdoor-factory bdf-proxy/bdf/

cd bdf-proxy/bdf/
./install.sh
cd ..
./install.sh
cd ..

echo "patching bdfproxy config..."

patch bdf-proxy/bdfproxy.cfg < patch/bdfproxy.cfg.patch
patch bdf-proxy/bdf_proxy.py < patch/bdf_proxy.py.patch

#patch bdf-proxy/bdf_proxy.py < patch/bdf_proxy.py.patch
#patch bdf-proxy/bdf/pebin.py < patch/pebin.py.patch

echo "..DONE.."
exit
