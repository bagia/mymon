Retired project
======
Facebook fixed the underlying issue this system was using.

In a nutshell, when publishing a post associated to an image that didn't exist (the server called for it would always reply 404), Akamai did not cache the result of the query. Anytime someone would see the post on Facebook, since the image had not been cached, Akamai would send a request to the server supposed to host the image. By toying with post permissions, this system was able to know if a specific person had visited a profile: if a post was visible to only one person, then any request coming for the image associated to this post would have to come from this person visiting the profile.

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

Frequently Asked Questions
=======

#### What is the site's purpose?

My Monitor provides you with a way to monitor your Facebook profile. In this way, you'll know exactly who's stalking you (and who's not), and at which frequency.

You can do this by setting up "watchdogs" to receive an alert when a specific person in your friend list is visiting your page. This website will help to deploy these watchdogs :

*   in a way that will allow you to track a single person or a group of person
*   in a way that will allow you to track - almost - your entire friend-list
*   in a way that could tell you whether a visit was made by someone in your friend-list or someone else (search engine, friend of friend, etc.)

#### What is a watchdog?

A watchdog is a "trick" article on your Facebook profile, that is associated to a fake image link pointing to one of our servers. In this way, when someone visits your page, Facebook tries to load the image and our server which therefore can deduce that someone accessed your profile.

#### How do I create a new watchdog?

First, go to "My watchdogs" on the upper right of your screen. Then, click on "New". You then have to enter in the first form a link (e.g. http://www.example.com/article) to an article you think your friends will ignore if published on your profile. In the second form below, give the name of the watchdog as it will appear on your monitoring page. You can then choose whether you want to enable notifications on this Watchdog or not, namely whether you want to be notified on Facebook when someone has visited your profile. Finally, simply click on "Publish", and wait for the progress indicator to be finished. That's it, your watchdog is in place.

Then, you can go on your Facebook profile to modifiy the confidentiality parameters for this watchdog. For this, click on the icon next to the indicator telling how long ago your post was published. You can then choose to make it public (i.e. any facebook user accessing your page can see it), allowing only your friends to see it, allowing only yourself to see it, or by choosing "Custom", you can choose exactly what friend(s) or group(s) of friends can see it.

#### How long do I need to wait for my watchdogs to be active?

You have to wait 5 days for your watchdogs to be active, the reason being that for the first few days, your post will appear on your friends' newsfeeds. If you choose a link to an article that you are sure almost no one will click on, then after 5 days, it won't be on anyone's newsfeed. In this way, you can then be sure that when the counter is incremented, it is due to a visit to your profile.

#### What is a "power-watchdog"?

A power-watchdog allows you to track each and everyone in your friends' list, by creating a post for each of them, and configure the Facebook confidentiality parameters in such a way that only one singular friend can see each post. In this way, you can know not only how many people accessed your profile, but who exactly.

However, since Facebook doesn't allow the publication of hundreds of posts from a single user in a short amount of time, the power-watchdog publishes a post for one hundred of your friends a day, taking a few days till it has a post for all your friends (if you have more than a hundred friends). In other words, it publishes a post for one of your friends every 15 minutes.

In this way, you can know exactly who'll be visiting your profile.

#### How do I create a "power-watchdog"?

First, go to "My watchdogs" on the upper right of your screen. Then click on "power". You then have to enter in the form a link (e.g. http://www.example.com/article) to an article you think your friends will ignore if published on your profile.

You can then choose whether you want to enable notifications on this Watchdog or not, namely whether you want to be notified on Facebook when someone is visiting your profile. Finally, simply click on "Publish", and wait for the progress indicator to be finished. That's it, your power-watchdog is ready to be launched.

About every 15 minutes, until there's a watchdog for all of your friends, My Monitor will create a watchdog for one friend in your friends' list. As is the case for single watchdogs, you'll have to wait 5 days between the creation of any watchdog and the watchdog's activation.

#### How do I delete a "power-watchdog"?

First, go to "My watchdogs" on the upper right of your screen. Then click on "delete power".

That's it, My Monitor will then delete each watchdog created by the power-watchdog, one by one, till there's none left. You can follow the progression of the deletion on the upper right of your screen. Every Facebook post associted to a power watchdog will be deleted from your Facebook page.

#### Can I rename a watchdog, and if so, how?

First, go to "My watchdogs" on the upper right of your screen. Then, click on "edit" on the right of the watchdog's name that you want to rename. Then enter the new name, and click on "save".

#### How do I log out?

Click on your profile picture on the upper right of the screen. Then choose "Log out".

#### How do I delete my account?

Click on your profile picture on the upper right of the screen. Then choose "Settings". Click then on "Delete my data". This will permanently delete any data concerning you on this site. Note that you'll remain authenticated on the site through Facebook until you disallow the application on Facebook.

#### Under what terms is licenced the code of My Monitor?

The code of this website is licensed under the terms of the GPL v3\. Everything you want to know on these terms can be found on the following page: [http://www.gnu.org/licenses/quick-guide-gplv3.en.html](http://www.gnu.org/licenses/quick-guide-gplv3.en.html).
