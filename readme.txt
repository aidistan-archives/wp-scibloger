=== Science Blog Helper ===
Contributors: aidistan
Donate link: http://www.crcf.org.cn/1030/juankuan.asp
Tags: scibloger, science, helper, post, content, latex
Requires at least: 3.3
Tested up to: 3.9.2
Stable tag: trunk
License: MIT License

Intended to help people build blogs and write posts on science. Provide functions like LaTeX support, post outline generation and so on.

== Description ==

This plugin aims at helping you build blogs and writing posts on science.

= Main features =

A list of features provided by now,

* LaTeX Support
* Post Outline Generation

= LaTeX Support =

This function is realised by importing copy of **MathJax**, an open source JavaScript display engine for mathematics that works in all browsers, from their CDN Service.

Simply use \\(...\\) to wrap your in-line math or \\[...\\] to wrap your equations. For more info, please visit MathJax [Homepage](http://www.mathjax.org/) or [Documents](http://docs.mathjax.org/en/latest/).

= Outline Generation =

Posts on science usually are long works. SciBloger will help you generate a useful outline as long as headers were set properly: making h3 the top level in your post; h4s, h5s, h6s follows by order.

Shortcode is also supported to generate outline more flexible:

[scibloger_outline show="yes" right="10px" top="20%"]

= Need more features? =

In order to get new features, you could contribute to it directly on Github or contact me.

= Contact me =

Post issues on Github or email to ([aidistan@live.cn](mailto:aidistan@live.cn)). Any suggestion or question is welcome.

== Installation ==

= Install latest stable by wordpress =

* Select "Installed Plugins" in "Plugins" menu
* Search "SciBloger"
* Follow the instructions to install it

= Install by hand =

* Download any stable version zip from WordPress or [plugin homepage](http://aidistan.github.io/aidi-wp-scibloger/)
* Unzip it and put the folder under path-to-your-wordpress/wp-content/plugins/
* *Notice: Installing development version requires a little knowledge about WordPress plugin layout.*

== Frequently Asked Questions ==

No question by now.

== Screenshots ==

1. LaTeX equation

2. Outline basic style

3. Outline metro style

== Changelog ==

= 0.2.6 =
* Add an option page for MathJax

= 0.2.5 =
* Use [Mobile_Detect](https://github.com/serbanghita/Mobile-Detect) to detect whether isMobile.
* Load different CSSs dependent on your device.

= 0.2.4 =
* Add a theme option for Outline in Maximal mode.

= 0.2.3 =
* Fix a severe bug in Outline.

= 0.2.2 =
* Change plugin name to the formal full one.
* Fix some typos.

= 0.2.1 =
* Improve the styles used in Outline module.

= 0.2.0 =
* Add outline generation function.

= 0.1.0 =
* Start version of SciBloger, only containing LaTeX support.

== Upgrade Notice ==

Nothing to worry about.

== License ==

= SciBloger =

The MIT License (MIT)

Copyright (c) 2013 Aidi Stan

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

= Mobile_Detect =

MIT License

Copyright (c) <2011-2013> <Serban Ghita> <serbanghita@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Developer’s Certificate of Origin 1.1

By making a contribution to this project, I certify that:

(a) The contribution was created in whole or in part by me and I
    have the right to submit it under the open source license
    indicated in the file; or

(b) The contribution is based upon previous work that, to the best
    of my knowledge, is covered under an appropriate open source
    license and I have the right under that license to submit that
    work with modifications, whether created in whole or in part
    by me, under the same open source license (unless I am
    permitted to submit under a different license), as indicated
    in the file; or

(c) The contribution was provided directly to me by some other
    person who certified (a), (b) or (c) and I have not modified
    it.

(d) I understand and agree that this project and the contribution
    are public and that a record of the contribution (including all
    personal information I submit with it, including my sign-off) is
    maintained indefinitely and may be redistributed consistent with
    this project or the open source license(s) involved.
