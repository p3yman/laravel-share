# Laravel Share
Laravel Share is an easy way to share any data through a request. 

## Introduction
With Laravel Share you can share any data through a request to use later. You can use it to manage assets, make menus, save a filter callback or make a table.
In simplest way you can use is this way:
`
Share::make('Person')
	       ->add('name', 'Peyman')
	       ->add('email', 'salam@peyman.me')
	       ->add('job', 'Web developer')
	       ->edit('title', 'Mr');
`
