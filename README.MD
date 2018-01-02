# Introduction
This is a tool that is used to build real-time [SA-MP](http://sa-mp.com) server signatures.

I made this tool back in 2014 and released it(didn't open sourced it though) on SA-MP forum in 2015 but it was buggy at that time so it didn't catch any attention. I recently fixed major bugs and as I have no intention of improving this project anymore so I decided to make it open-source.

I wrote this code when I was a newb to web development, so the code may not be written in the best manner and can probably be optimized/improved.

Works best with google chrome, didn't test with firefox and I am pretty sure it won't work with edge/IE.

[**You can use this tool by clicking here**](http://exmserv.me/sampsig)

## Features
* Drag-drop interference for easily designing the signatures.
* Option to use custom fonts. *
* Option to use custom font colors.
* Option to add outline/stroke to text.
* You can either use a solid color or a custom picture as a background, has the option to upload or use image by URL. **
* Additional images can be added too via URL or by uploading. **

#### * Fonts are uploaded to the server to the '/gd_fonts/' directory by default.
#### ** Images are not uploaded to server, they are uploaded to [imgur.com](https://imgur.com)

# Demo
[![Demo Link](https://i.gyazo.com/be5a82b232ed747084e1c640f8874a98.png)](https://www.youtube.com/watch?v=bLJzrgltMjU)

# External Libraries used
* [SampQueryAPI](http://forum.sa-mp.com/showthread.php?t=104299)
* [jQuery](https://jquery.com/)
* [colpick](https://github.com/josedvq/colpick-jQuery-Color-Picker)
* [bPopup](http://dinbror.dk/bpopup/)
