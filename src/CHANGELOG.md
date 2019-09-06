# Change Log
<div class="clear"></div>
#v0.9.10 | 2019-xx-xx

* updated laravel 5.3 -> 5.4
* migrated from cartalyst/sentry -> cartalyst/sentinel
	* updated roles and permissions scheme
* adds missing bowerfile (before i can get around to kick bower)
* fixed error when trying to save profile info
* fixed error display in some password reset conditions
* fixed error formatting for forgot-password error

#v0.9.9 | 2019-09-05

* general page performance improvements
* updated laravel 5.2 -> 5.3
* removed unnecessary packages

#v0.9.8 | 2019-09-04

* adds patreon button
* adds debugbar for dev
* improve home loading perf
* improves settings querying performance
* fixed difficulty selection when trying to create new track for song
* fixes requiring password when changing settings

#v0.9.7 | 2019-09-04

* removed facebook login functionality
* fixed error display during registration
* updated laravel 5.1 -> 5.2
	* refactored custom form field
	* refactored middleware

#v0.9.6 | 2019-09-04

* added base docker files
* removed obsolete vanilla forum code
* fixes issue with counting in dashboard
* fixes route issues
* fixes compatibility issues

#v0.9.5 | 2016-04-16

* fixed issue when opening a track page from a player score which can't be decompressed
* bump (C) year
* added GPLv3 LICENSE

#v0.9.4 | 2015-09-13

* changed score manipulation detection

#v0.9.3 | 2015-07-17

* updated framework core
* fixed bug in reset password functionality

#v0.9.2 | 2015-07-17 | cheaters, learn to play.

* increased loading speed of player
* NEW score manipulation protection
* fixed bug when quick restarting and pressing space
* fixed wrong url to forum in songlist

#v0.9.1 | 2015-06-28

* fixed bug when saving settings
* fixed display of artist short bio on player page

#v0.9 | 2015-06-27 | core upgrade

* upgraded rocklegend core to l5

* changed/optimized facebook registration/login process
* improved login/registration handling
* fixed bug in facebook user generation
* removed deprecated routes
* removed deprecated files
* cleaned up codebase
* new file/folder structure

* updated to new messaging system


#v0.8.6.7 | 2015-06-24

* fixed: bug when trying to save settings
* (should be) fixed: player on mobile devices

#v0.8.6.6 | 2015-06-23

* fixed: security issue on registration
* changed: max username length to 20 characters

#v0.8.6.5 | 2015-06-22

* removed: live chat
* fixed: rankings page loading twice

#v0.8.6.4 | 2015-06-16

* added: we now support https!
* fixed: using html5 audio in the player where available. this fixes a problem where sounds would be played in lower quality after restarting a song

#v0.8.6.3 | 2015-06-13 | Start to rock EVERYWHERE!

* added: you can now play rocklegend on your mobile device, thanks to added touch events ;)

#v0.8.6.2 | 2015-06-13
<div></div>
### player

* further improved player performance by reducing drawing calls
* changed sustained note tails to sprite images
* increased speed of score render update
* reduced amount of particles generated at the beginning (from 2.500 to 1.750)

### editor

* improved editor performance by reducing drawing calls

#v0.8.6.1 | 2015-06-13

* fixed a bug where note streak would get reset much later after you missed a note
* fixed broken instant restart
* fixed highscores of this week/day not updating if it's lower than alltime highscore
* enabled realtime "vs" play against previous highscores of users

#v0.8.6 | 2015-06-11
<div></div>
### website

* added: info about track next to player

### player

* (soon) added: we now save track your score data while you play a track and save it. when you click on the score of someone else, his/her scorebar will move accordingly to his/her performance :)

#v0.8.5.2 | 2015-06-09
<div></div>
### website

* fixed: bug where some users couldn't register with facebook
* fixed: some tracks showed no difficulty
* fixed: bug where every track would display the same comments

### player

* optimized: grid lines are also loaded from spritesheet
* improved overall performance
* improved score rendering performance
* changed: (testing) note position is not linked to audio playback but to internal timer now
* changed: hiding sustained note tail after hitting it and leaving the key
* fixed: memory leak

### editor

* fixed: button image when pressing

#v0.8.5.1 | 2015-06-08
<div></div>
### player

* fixed: bug where notes would not be rendered
* fixed: wrong note image for HoPo notes
* improved: hit detection
* changed: now loading all notes at once (= faster)

### editor

* fixed: mute function
* fixed: play/pause functionality
* fixed: DnD note selection

#v0.8.5 | 2015-06-07
<div></div>
### website

* added: info text about forum downtime
* changed: minor changes in home page text

### player

_huge performance update_

* added: current song time indicator in player
* updated phaserjs to v2.3.0! :)
* fixed: bug which occured when opening a playpage of a deleted track
* changed player audio library to howler.js
* changed player code to use one spritesheet instead of multiple
* set defaults of animateHitLanes to false and displayMode to AUTO
* caching results for getPosXForLane and getXForLaneButton
* removed most of the AudioManager code (directly using play/stop etc methods instead)
* improved drawing of grid (reduced draw calls to 1/4 of previous amount)
* improved drawing of progressbar
* improved button and note drawing
* minor optimizations of hit logic
* changed RL.Note to use lighter Phaser.Image instead of Phaser.Sprite as base class
* improved particle emitter

### editor

_huge performance update_

* removed stats.js from editor
* updated editor to phaserjs 2.3.0, updated editor soundjs to 0.6.1
* editor now uses 'AUTO' as displayMode
* optimized editor AudioManager for soundjs 0.6.1
* fixed and optimized beatline rendering (previously times would be calculated wrong and rendering beat lines needed a lot of hardware power)
* optimized overall editor performance (now it needs only 1/10 of the previous drawing calls amount!!)

#v0.8.4.14 | 2015-06-03

* added: official trackers can now download .mp3 and .ogg files via the track editor page

#v0.8.4.13 | 2015-06-02

* fixed: bug in MIDI parser which caused errors when uploading some midi files

#v0.8.4.12 | 2015-03-10

* updated, improved error handling

#v0.8.4.12 | 2015-03-10

* We switched to a new, more powerful server!
* fixed: empty track comments bug

#v0.8.4.11 | 2015-02-06

* added: you can now Copy&Paste using the standard copy&paste keyboard shortcuts in the editor!
* added: simple & basic ranking page
* added: custom 404 error page
* added: custom 500 error page
	* we now also get notified about all errors which occur
* fixed: possibility to open a track in the editor with a wrong song / vice versa
* fixed: possibility to clone tracks from other users for use in your own account
* fixed: various security issues
* fixed: removed x from close button in badge notification
* updated: phaserjs v2.2.2 & pixijs v2.2.0

#v0.8.4.10 | 2015-02-04

* added: badges in user profile tooltip box
* changed: new players can't use whitespace or any special characters in their user name
* fixed-security: avatars can only be jpg, jpeg, png or gif files
* fixed: user highscore rank would be wrong in user profile and on home
* fixed: when replying to a comment, song play would be triggered when using spacebar or r keys
* fixed: multiposting of same comment is not possible anymore
* fixed: no more empty comments

#v0.8.4.9 | 2015-01-25

* added: when you minimized the chat, you'll now see a little indicator for the amount of messages you have not read yet on the current page
* changed: quick restart now requires you to press the quick restart key twice fast (helps to prevent accidental restarts ;) )
* fixed: a bug where clicking a notification, you'd be redirected to an undefined url
* fixed: a bug in the player where long notes could be pressed at the end of the song and your score would increase even though the note already ended
* fixed: redirect to home when sending a message in conversation

#v0.8.4.8 | 2015-01-24

* fixed: bug which prevented score badges from unlocking due to highscore change
* fixed: small javascript bug

#v0.8.4.7 | 2015-01-24

* fixed: bug which caused an error on profile pages
* fixed: bug which caused an error on badge pages
* changed: we now add all old scores to the user profile statistics (so for users who played a lot in the past, these
stats really reflect their progress

#v0.8.4.6 | 2015-01-23

* HIGHSCORE RESET
* changed:  highscore database structure
	* decreased number of queries and complexity for most of the score stuff
	* easier score management
* changed: highscore listings logic
* removed: unnecessary queries (improves performance of every page)
* fixed: a security issue which allowed cheat scores to be published
* added: indiegogo campaign teaser
* removed: "Help us" section

#v0.8.4.5 | 2015-01-01

* fixed: bug when registering with facebook
* fixed: bug when you played your 100th song
* changed: loading player assets via external cdn - should improve loading speeds

#v0.8.4.4 | 2014-12-07

* fixed: broken redirect after donation

#v0.8.4.3 | 2014-12-05

* added: "Help Us!" page
* added: you can now click on badge thumbnails to view the badge in large format

#v0.8.4.2 | 2014-12-03

* website - added: badge overview - you can now check which badges are available :)
* editor - added: you can now place hopo notes by holding CTRL while tapping your configured keys
* player - fixed: instant-restart key triggered restart even when just writing a comment or text message

#v0.8.4.1 | 2014-12-02

* added: quick restart key! you can now define a key which restarts the current song instantly (default: R)

#v0.8.4 | public beta | 2014-11-30

We've finally opened the doors for everyone. Let's hope nothing breaks :)

### website

* added: badges! you can find your badges at your profile page :)
	* when you play a song and get a badge, you'll see an info overlay at the bottom left of the page
* added: possibility to signup with a special code (can be used for special perks in the future)
* changed: PUBLIC beta :) it's now possible to register without an invitation code
* changed: there's now a maximum height set for the track list, visible in official tracker profiles
* fixed: non-updating live user count in chat
* fixed: script error when not logged in
* fixed: redirect to conversation message response when logging in

### notifications

* added: when you follow an official tracker and he/she publishes a new track, you'll now receive a notification

#v0.8.3 | 2014-11-28

This update could break a thing or two due to some architectural changes. Please report any issues you find in the forum! Thanks.

### website

* new: new realtime service
	* custom made realtime service, we're now able to create awesome realtime experiences#
* new: realtime push notifications
	* if there are new notifications, you don't need to reload the page to see them - they are  automagically delivered to you like notifications on your smartphone

* re-added: chat with newly implemented realtime system
	* added: number of users online is now visible in the chat handle :)
	* please report any bugs with the new chat system in the forum, thanks!

* added: a few user profile additions
	* last highscores
	* profiles of official trackers now also list their created tracks
	* list of followed users

* changed: new highscores instead of latest scores on frontpage
	* now includes all-time rank of score
	* new layout

* fixed: bug where hot tracks without difficulty selection break layout

### player

* changed: removed soundjs from player and using phaserjs own soundmanager
* changed: optimized player code = less memory usage = better performance
	* simplified note initializiation
	* removed duplicate & unused code
	* extracted general functions from note object
* optimized build process
* fixed: lag when scoring a sustained (long) note
* fixed: sustained notes danced around when scoring them

### editor

* changed: minor note positioning adjustments
* changed: performance optimizations
	* only drawing currently visible notes
	* improved update loop performance
		* removed hittable notes handling
* fixed: notes don't jump around anymore by just clicking on them :)

#v0.8.2.4 | 2014-11-25

* fixed: if not logged in - error on profile detail page

#v0.8.2.3 | 2014-11-18

* fixed: official trackers can now test-play tracks from other trackers

#v0.8.2.2 | 2014-11-17

It's easier to find available tracks, and less clicks are needed to play them.

### Website

* added: songlist page - all available songs on one page without clutter
* added: new discover page - find stuff to play easier, and faster
* added: hot tracks & newest tracks on the home page
* changed: color overlay for page divider
* changed: removed global chat - we're going to add it again once we implemented our new realtime system

### Player

* fixed: strum must be used when failing on hopos/streak is zero

### Editor

* changed: removed player gradients on editor

#v0.8.2.1 | 2014-11-13

We're getting closer to open beta with every update!

### Website

* added: imprint and tos
* fixed: "Edit Track" link for official trackers & admins

### Player

* changed: when playing in "Test Play" you'll also get the score screen now - scores won't be submitted though
* [STRUM MODE] changed: when strumming during a sustained note, sustained note will break and multiplier / streak resets
* [STRUM MODE] fixed: a bug where streak/multiplier would be reset when strumming - even though you hit a note

#v0.8.2 | 2014-11-12

We added a "Country" filter for highscore lists. For this to work the way it is supposed to, please update your country information on <a href="/profile/edit">your profile</a>.

### Conversations

* added: "Send on ENTER" toggle, so you can write longer messages easier
* fixed: line breaks get recognized in message view now
* fixed: you could send messages with no content, this is not possible anymore
* fixed: long urls, word, sentences break correctly now

### Website
* added: __awesome__ highscore lists!
	* region filter: global, your country, followed users
	* timespan filter: all-time, month, week, today
	* your position - relative to all filters
* changed: tooltip behavior and styling
* changed: position of notification list overlay
* fixed: a bug where profile boxes could be opened from within profile boxes
* fixed: header bug where height wouldn't be set correctly in some browsers

#v0.8.1.1 | 2014-11-12

* fixed: a bug which caused funky rainbow colored note highways _whoops_

#v0.8.1 | 2014-11-12

### Editor
* added: you can now select multiple notes by dragging a rectangle around them!
* added: when selecting notes with a rectangle selection, moving the mouse to the top or bottom of the player automatically seeks through the track so you could even select all notes of a track using this feature
* added: you can now copy and paste notes!! :) we're going to add a little "paste-helper-line" later
* changed: now using the same code to display the button keys as in the player. this should give a (very) minor performance boost
* changed: minor design changes to make the editor more compact
* changed: instead of selecting the amount of lanes you want to track, you can now select the difficulty
* changed: when creating a new track, you'll only be able to choose a difficulty which doesn't have a published track yet. you'll also see who published an existing difficulty
* changed: preventing default browser functions of F1-F11 for use as keyboard keys
* fixed: non-official trackers could publish tracks - this is fixed now, so only official trackers can publish, all other users have to set their tracks to "review" -> this will notify us that there is a new track that we should check and set to published.
* fixed: due to changes in the new PIXI.js version, the "Show times" feature didn't work. This is fixed now (+faster than before)

### Player
* fixed: hopos were shown in tap mode when recycling a note and reinitializing it with a hopo note

#v0.8 | get social and start strumming | 2014-11-08

This is a massive update with lots of new features and enhancements. If you find new bugs, please report them on the forums!

### rocklegend.org
* added new "info" tooltip when hovering over a users name
* added notifications
	* new: notification when you receive a new message
	* new: notification when somewhen replies to your track comment
	* new: notification when there's a new comment on a track you created
	* we can easily add new notifications, so tell us what you'd like to be notified about :)
* added "Follow" Feature to keep track of a users progress, played songs, scores... (features for followed users will be pushed within the next updates)
	* follow from user tooltip or user profile
* added "Messages"
	* you can now start conversations with one or more users (like groups)
	* messages sent within the conversation view update in near _real time_ (chat like)
* added easier user management for admins (suspend, ban, official tracker, pw reset)
* added facebook like box to artist detail pages
* optimized player page
	* increased initial loading speed
	* optimized styling and got rid of FOUSC
* changed: home
	* added twitter feed
	* changed info text
* changed: discover page now shows 3 artists per row
* changed: track comments date is now relative and human readable
* changed: "Selected Artist" box in discover scrolls with view
* changed: "More from this artist" scrolls now on player page
* fixed flickering, position and dimensions of loading overlay

### Player
* added strum/tap mode toggle
	* you can choose a default mode in "my settings"
	* you can change the mode for the current track via the tracks info screen (before the track starts)
* added a relaxed version of "HO/PO" notes for strum mode (notes must be manually updated by trackers)
* added "replay" button
* changed: fast song restart! -> replay uses current game instance - no need to reload assets, much faster, very wow
* fixed bugs when restarting a song

### Editor
* added HO/PO property for notes in editor (for strum mode)
* added currently selected note count to note details
* added "deselect all" function
* massive "selection" optimizations
	* remembering selected notes when dragging multiple notes -> no need to reselect notes after dragging them
	* enhanced "selected note" image
	* differentiating between click and drag
	* try selecting and dragging notes to better understand the changes
* fixed multiselection note info bug
* fixed note detail fields are now readonly by default

# v0.7.3.3 | 2014-11-05

* optimized overall page performance (faster loading times, less requests)
* fixed a bug in editor where note distance isn't set correctly

# v0.7.3.2 | 2014-11-01

* fixed a bug where you couldn't remove notes in editor after deleting one or more note

# v0.7.3.1 | 2014-10-28

* added "move all notes by x ms" feature to editor

# v0.7.3 | 2014-10-27
This update contains changes which might affect your settings. Please check if your Keyboard settings have changed, and reset them accordingly.
## Player
* added alternative keyboard configuration in "my settings"
* added settings screen for player (little cog icon on the bottom left in the player)
	* maximum notes on screen
	* amount of sparkles on hit notes
	* toggle cheering
	* cheering volume
	* render mode: webgl or canvas
* decreased default cheering volume
* changed sparkle graphics
* updated phaserjs version *yeah*
* removed unnecessary overhead from player script

## Editor
* optimized dragging of notes
	* you can now drag multiple notes simultaneously
	* tail of sustained notes moves in realtime
	* color changes in realtime
* changed input field types
* changed multiple note info behavior

# v0.7.2.1 | 2014-10-10

* added markdown parser to about me text
* slightly increased chat width

# v0.7.2 | time to chat | 2014-10-10

* added "realtime" chat
	* we currently enabled markdown parsing. so you can use markdown syntax to format your chat comments.
	* automatically parsing links
	* creating channels etc. will be implemented later
	* only available in browsers which support websockets
* added markdown parsing to track comments
* changed: disabled tick nois by default in editor
* changed: when you create a new track we fixed a minor "editor-breaking" bug

# v0.7.1 | 2014-10-10

* fixed a bug where new tracks couldn't be created
* fixed wrong hit percentage bug

# v0.7 | 2014-10-10

* added midi upload for "official trackers"
* added a variety of additional caching mechanics
* added new profile data
	* you can now add a short description, country, as well as a few other things to your profile (just click on your username)
* added focus mode (again)
	* focus mode now activates itself automatically during countdown
	* focus mode deactivates itself automatically after song ended
* changed note sparkles for better visibility
* optimized compression of audio files -> decreased file size = faster loading times
* changed behavior of player when only "3 lanes" are enabled for a track
* fixed a note count bug
* fixed track not updating in player when changed in tools due to 60 minute cache
* fixed wrong labels in user profile
* fixed wrong key labels in player
* fixed wrong date in changelog. 2015 is not here yet ;)

# v0.6.6.1 | 2014-10-09

* added admin & official tracker label to profile and prepared for additional information
* various backend optimizations for faster page loads

# v0.6.6 | 2014-10-07

* added score-bars to player

# v0.6.5.1 | 2014-10-07

* changed: only saving the last 10 versions of a track (track history)

# v0.6.5 | 2014-10-05

* added difficulty name in player "info" screen
* added "reply to comment" and minor design changes for comments
* added function to change number of lanes in editor
* added "buy this song" button at the end of the song
* changed: showing only the highest score of a user in highscores
* fixed a bug in firefox where comments get posted twice

# v0.6.4 | 2014-09-29

* DRAWING optimizations!
	* you should now be able to play rocklegend with firefox. we further optimized the player and reduced the amount of calculations we need to to each frame. just to give your an idea of what we accomplished with these last updates:
		Canon Rock by Jerry C - Expert
		* Previously:
			- 1473 notes in memory ( = 1473 updated notes per frame )
			- 6503 drawing calls in EACH FRAME! (crazy huh?)
		* Optimized:
			- 35 notes in memory
			- only as much drawing stuff done as we really need to -> approx. 70 calls for the most time in canon rock!

* changed sound library to use webaudio if available - this massively improves performance in firefox

# v0.6.3 | 2014-09-29

* MASSIVE performance bump
	* previously we've loaded all notes of a track directly into the memory. for canon rock this means that more than 1300 notes were already on the stage even if they weren't visible.
	we changed the whole display logic and now theres a fixed limit of notes at a time on the stage and used notes get recycled. this increases performance of the player A LOT! If you weren't able to play songs such as Canon Rock or The Escape previously - you should be able to now.
	Use Google Chrome for best performance and enjoy.

* fixed difficulty selection bug in editor

# v0.6.2 | 2014-09-27

* a bunch of player performance optimizations
* added "Play Ticks" to editor
* decreased height of player
* changed default displaymode to CANVAS (should increase performance for most users)
* fixed status of clone tracks is now draft automatically

# v0.6.1 | road to a better editor #1 | 2014-09-26

* various editor changes
	* added: difficulty selection
	* added: admins get notified when you change a tracks state to "review"
	* added: automatically hiding "last saved" box 	after 3 seconds
	* changed: changing a track from published to draft or review is no longer possible for normal players
	* minor changes to the editor layout
	* fixed a bug where notes would move a few pixels down when clicked
	* fixed muting track was not possible in editor

# v0.6.0 | #thisistheplayer | 2014-09-26

* added login with facebook + function to connect existing accounts
* added track commenting system
* added (work in progress) highscore list under player
* added artist info under player

* added awesome player loading screen
* added "Count Down" before song starts
* added "info screen" before you pressing start
* added cheering crowd on specific streak numbers (this will be changed to be more dynamic later)
* added experimental strum mode (currently hidden, you'll be able to activate it in an upcoming update)
* added score info + some functions on song end
	* replay song
	* "share score"
	* "next song"
* added auto-deactivating focus mode on song end

* changes to the score system (thanks Caylara)
* changed some things with hit detection - less hardcore
* changed player design
	* slightly decreased note size
	* slightly decreased player width
	* smaller sustained note tails
	* changed score display box

* fixed wrong note "hit" count being saved after song end
* fixed sustained note bug ( infinite scores )
* fixed browser window scrolling when pressing space
* fixed a hit detection bug which overwrote hittable notes even if other notes would make more sense
* fixed a bug where invite codes became invalid after unsuccessful registration

## v0.5.8 | Minor Changes | 2014-09-16

* fixed: facebook metadata
* fixed: bug where artist page couldn't be viewed while not logged in
* changed: discover section now available for public

## v0.5.7 | Bugfix | 2014-09-15

* added: song progress/time bar in player
* fixed: changing note duration or time via note inspector caused weird behavior
* changed: track name section in tools shows track id now

## v0.5.6 | So, you forgot your password | 2014-09-15

* added: password reset functionality

## v0.5.5 | Changes + Additions | 2014-09-15

* added: custom artist header images
* added: editor time lines + grid (snapping not yet implemented but coming somewhen later)
* added: editor note detail settings (directly edit time, duration and lane of notes)
* re-added: editor track taps
* optimized: player performence increased by approx 12-16%
* changed: long note threshold in editor for tapping is now down to 130ms, you can set it down to 75ms via the note detail settings
* changed: always show trackable and requested tracks in discover
* changed: show artist profile even if not logged in
* changed: slightly increased visibility of notes hit via the note lane
* removed: custom track names
* removed: custom options for discover section

## v0.5.4 | Editor Additions | 2014-09-13

* added: there's now a trash section with your deleted tracks in the tools
	* you can revive or force delete your tracks from there
* added: you can now clone your tracks to create multiple difficulties more easily or try different versions
* added: we now save each new version of your track to ensure that if anything goes wrong we can rollback your track to a previously working version
* added: you can now test-play your tracks before they are published
* fixed: deleting a track now also deletes associated scores
* changed: there are only 3 trackstates now: draft, review, published
* changed: default avatar
* changed: editor status information tooltip
* changed: tracks with less than 100 notes can't be published automatically, they have to be reviewed first


## v0.5.3 | Bugfix | 2014-09-13

* fixed in editor:
	* bug where notes would suddenly get reset to an earlier position if their new position is to "high" and trying to drag them
	* bug where multiple notes would be generated when creating sustained notes
	* tried to save score at the end of the song

## v0.5.2 | Bugfix | 2014-09-12

* fixed: editor: bug where note distance setting wouldn't work
* fixed: editor: bug where note distance wouldn't be saved when creating a new track

## v0.5.1 | "Highscores" | 2014-09-10

* added: songstates
* added: show trackable / requested songs settings
* added: home shows actual last played songs from user if logged in, global if anonym
* added: saving highscores, missed/hit notes, max streak/multiplier for each playthrough
* added: songs can be deactivated for tracking now
* added: we can display requested songs for artists as seperate listings
* added: displaying non-tracked songs in song discovery
* added: directly like a bands facebook page or subscribe to their youtube channel via their band profile
* added: short artist biography in discover section
* added: track status selection in editor
* updated: invite emails
* deleted: deprecated links

# v0.5 | "Features.2" | 2014-09-09

* changed: "songs" section is now "discover"
* changed: login anywhere -> login box in header
* new: "Artist" profile page
* new: Discovering of songs is really awesome now
* new: Give your created note tracks a name
* new: Added various artist metadata
* new: activate focus mode when playing
* new: loading assets text in player
* new: sharing player url in facebook displays correct song metadata
* removed: toggle tracking in editor
* optimized: page animations
* optimized play template & scores
* optimized: internal changes to track handling, we tested and everything seems to be working. may cause issues though (especially dashboard)
* optimized: hit detection of sustained notes and multiple notes in a row
* optimized: player performance
* fixed: score multiplier and reset
* fixed: resizing window now forces repositioning of scorebox
* fixed: version in footer
* fixed: broken profile view in header in firefox

## v0.4.1 | 2014-09-07

___Game:___

* added "Press Space to play" to play template
* optimized preloading
* optimized score mechanics (sustained notes)
* optimized code structure
* optimized hit detection
* changed music handling
* fixed: play button in play mode restarted song
* fixed: a bug where notes weren't removed from the hittables
* fixed: a bug where notes would still be hittable after their endtime
* fixed: note deletion bug
* fixed: a bug which caused notes to be saved on wrong lanes
* fixed: deleting sustained notes
* fixed/enhanced: sustained notes hit detection
* fixed: createText function didn't get called in some cases (no "Key" hints on buttons)
* fixed: handling midiimported notes correct
* fixed: notedistance bug where speed changed, but note distances stayed the same
* fixed: a bug where save notes wouldn't work because note array had wrong type
* fixed: handle different types of note data
* fixed: recalculating hit detection variables for sustained notes
* fixed: redrawing sustained notes when changing note distances
* fixed: there was an old version of the editor on earlyaccess.rocklegend.org

___Platform:___

* added: changing password via my settings
* added: login on medium screens from any page
* fixed: no user added when creating tracks via dashboard


# v0.4 | "Features.1"

___Platform:___

* editor:
	* added: autosave for editor
	* added: reloading page of track editor presents you with your current work instead of a new track
	* added: save your progress without changing the page
	* added: edit/delete your previously created tracks
	* added: saving of tracks only possible if more than 5 notes have been added
	* fixed: bug where note dragging resulted in breaking the whole editor
	* fixed: bug where editor tried to delete wrong notes
	* fixed: bug where changing note distance resulted in wrong note positions

* added: profile settings
	* change your profile picture
	* change your keyboard settings
	* change your autosave settings

* added: tools in navigation
* added: validation & error handling for login & registration
* some layout changes


## v0.3.1 | "Closed Beta"

___Platform:___

* new logo
* new design
* track editor
* rewritten, optimized player
* added registration
* added fe login
* added FT#1
* added invite logic

## v0.2.3 | 2014-05-04

___Game:___

* build optimizations

___Platform:___

* page payload optimizations
* cleaned interface from features not yet implemented

<!--

## v0.2.2 | 2014-04-26

___Game:___

* note highway optimization (improve sync between music.currentTime and bitIndex)
* added debug section to game and mrdoob stats for fps monitoring

___Platform:___

* sanitized routing
	* discover -> songs index
	* play/artist/song -> highscore, difficulty select and other additional infos (band)
	* play/artist/song/[difficulty] -> game
* sanitized notes retrieval
* directory using ids instead of slugs for changeability (and lateron - secure retrieval from storage)
* added changelog page with public changelog.md parsed as content
* added game translation file with translated difficulty level names


## v0.2.1 | 2014-04-21

___Game:___

* changed note highway
	* changed the buttons to images
	* new button styles
	* new note rendering/display
	* added a noteHit Threshold to increase note hit perception
	* different colored explosions for all lanes
	* now the game continues even if focus is lost
	* this fixes a weird input bug
	* removed lane highlighting

___Dashboard:___

* changed dashboard login screen


## v0.2 | "name" | 2014-04-16

___Game:___

* added phaser game framework variant

___Platform:___

* switched application framework to laravel
* added frontend and dashboard styles
* setup & implement role based authentication
* added basic song discovery overview page
* difficulty select
* updated frontend styles
* version management: release tags / versions
* issue tracker revival


## v0.1 | "Roots"

* Initial release
* A lot of awesome prework by @nesch -->
