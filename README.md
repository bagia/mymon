Retired project
======
Facebook fixed the underlying issue that it work.
In a nutshell, when publishing a post associated to an image that didn't exist (the server called for it would always reply 404), Akamai did not cache the result of the query. Anytime someone would see the post on Facebook, Akamai would send a request to the server supposed to host the image. By toying with post permissions, this system was able to know if a specific person had visited a profile...

My Monitor
======

My Monitor provides you with a way to monitor your Facebook profile. 

You can do this by setting up "watchdogs" to receive an alert when a specific person in your friend list is visiting your page. This website will help to deploy these watchdogs :
- in a way that will allow you to track a single person or a group of person
- in a way that will allow you to track - almost - your entire friend-list
- in a way that could tell you whether a visit was made by someone in your friend-list or someone else (search engine, friend of friend, etc.)

Setting up
==========
Rename ``config.ini.template`` to ``config.ini`` and edit its values. 

License
=======
This software is released under the terms of the GNU GPL v3 license.
