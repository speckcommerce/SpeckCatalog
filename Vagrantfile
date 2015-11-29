# -*- mode: ruby -*-
# # vi: set ft=ruby :

require 'fileutils'

# Uncomment or set to specific provider if you experience some provider issues
#ENV['VAGRANT_DEFAULT_PROVIDER'] = ''

Vagrant.configure("2") do |config|
  config.vm.provider "libvirt"
  config.vm.provider "virtualbox"
  config.vm.box = "fedora/23-cloud-base"

  config.vm.synced_folder ".", "/vagrant", id: "vagrant", :nfs => true, :mount_options => ['nolock,vers=3,udp']

  config.vm.provision "shell", privileged: false, path: "vagrant-setup.sh"
end

