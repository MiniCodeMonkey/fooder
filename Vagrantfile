# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "scotch/box"
  config.vm.network "private_network", ip: "192.168.23.10"
  config.vm.hostname = "fooder.local"
  config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=666"]

	# Use hostonly network with a static IP Address and enable
	# hostmanager so we can have a custom domain for the server
	# by modifying the host machines hosts file
	config.hostmanager.enabled = true
	config.hostmanager.manage_host = true
	config.vm.define "default" do |node|
	    node.vm.hostname = "fooder.local"
	    node.vm.network :private_network, ip: "192.168.23.10"
	end
	config.vm.provision :hostmanager

end