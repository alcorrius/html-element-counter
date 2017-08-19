# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|

    config.vm.box = "ubuntu/trusty64"

    config.vm.network "public_network"


    config.vm.synced_folder "./", "/home/vagrant/project", id: "vagrant-root",
                                                     :owner => "vagrant",
                                                     :group => "www-data",
                                                     :mount_options => ["dmode=775","fmode=664"]
    config.vm.synced_folder ".", "/vagrant", disabled:true


    config.vm.provider "virtualbox" do |vb|
    #   # Display the VirtualBox GUI when booting the machine
    #   vb.gui = true
    #
    #   # Customize the amount of memory on the VM:
     vb.memory = "1024"
    end

    config.vm.provision "shell", inline: <<-SHELL
        apt-get update

        ###install php and nginx
        apt-get install -y php5 php5-cli php5-fpm php5-mysql
        apt-get install -y nginx

        ###configure nginx
        ln -s /home/vagrant/project/public /usr/share/nginx/html/project

        cp /home/vagrant/project/_deployment/nginx /etc/nginx/sites-available/project
        ln -s /etc/nginx/sites-available/project /etc/nginx/sites-enabled/

        rm /etc/nginx/sites-enabled/default
        service nginx restart

    SHELL

end
