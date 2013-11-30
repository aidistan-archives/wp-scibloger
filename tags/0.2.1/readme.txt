=== aidi-wp-scibloger ===
Contributors: aidistan
Donate link: http://www.crcf.org.cn/1030/juankuan.asp
Tags: science, helper, post, content, latex
Requires at least: 3.0.1
Tested up to: 3.5.2
Stable tag: 0.2.1
License: MIT License

A WordPress plugin for science blog writer, providing functions like LaTeX supporting and post outline generation.


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

Post issues on Github or email to ([aidistan@live.cn](mailto:aidistan@live.cn)), any suggestion or question is welcome.

== Installation ==

= Install latest stable by wordpress =

* Select "Installed Plugins" in "Plugins" menu
* Search "scibloger"
* Follow the instructions to install it

= Install by hand =

* Download any stable version zip from WordPress or [plugin homepage](http://aidistan.github.io/aidi-wp-scibloger/)
* Unzip it and put the folder under path-to-your-wordpress/wp-content/plugins/
* *Notice: Installing development version requires a little knowledge about WordPress plugin layout.*

== Frequently Asked Questions ==

No question by now.

== Screenshots ==

1. LaTeX equation

2. Generated outline

== Changelog ==

= 0.2.1 =
Improve the styles used in Outline module.

= 0.2.0 =
Add outline generation function.

= 0.1.0 =

Start version of SciBloger, only containing LaTeX support.

== Upgrade Notice ==

Nothing to worry about.
