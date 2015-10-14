## Debian dev
------

### SO
----------------------------------------------------------------------------------------------------
**Debian minimal 64bits**

### Packages
----------------------------------------------------------------------------------------------------
* WebServer
* SSHServer
* Standard packages


### Install vim
----------------------------------------------------------------------------------------------------
`aptitude install vim vim-nox`


### Install mariadb-server
----------------------------------------------------------------------------------------------------
* Added to sources.list file the follow lines

**deb http://mirror.jmu.edu/pub/mariadb/repo/5.5/debian wheezy main**

* Run commands below
```bash
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xcbcb082a1bb943db
aptitude update
aptitude install mariadb-server 
```

### Install php5
----------------------------------------------------------------------------------------------------
`aptitude install php5 php5-dev php5-sqlite php5-mysqlnd`

### Install git
----------------------------------------------------------------------------------------------------
`aptitude install git`

* Configuring

```bash
git config --global user.name "<username>"
git config --global user.email "<email>"
git config core.editor "vim"
git config --global color.ui true
```

* Clone directory

`git clone https://github.com/lockland/sigec.git /var/www/sigec`

### Install php-pear
----------------------------------------------------------------------------------------------------
`aptitude install php-pear`

### Install composer
----------------------------------------------------------------------------------------------------
```bash
php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin/
chmod +x /usr/local/bin/composer
cd /var/www/sigec
composer.phar install
```

### Install xdebug
----------------------------------------------------------------------------------------------------
`pecl install xdebug`
 
* Configuring xdebug file
`vim /etc/php5/conf.d/xdebug.ini`

```vimL
; Enable xdebug extension module
zend_extension=/usr/lib/php5/20100525/xdebug.so
xdebug.remote_enable=1
xdebug.remote_handler = "dbgp"
xdebug.remote_host=127.0.0.1
xdebug.remote_port=9000
xdebug.remote_autostart=1
```

```bash
service apache2 restart
php --version # If xdebug appear on result the installation was success
```

### Install phpunit

### Install php_codesniffer
