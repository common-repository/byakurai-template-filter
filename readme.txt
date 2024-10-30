=== byakurai template filter ===
Contributors: yukimichi
Tags: 
Requires at least: 5.6
Tested up to: 6.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 7.0
Text Domain: byakurai-template-filter
Donate link: https://ci-en.dlsite.com/creator/13120

== Description ==

byakurai template filter is an add-on for the theme byakurai. This plugin automatically creates a page for editing each template. When you edit the body of the page for this template, the edited body is inserted instead of the original template parts of the theme.

#How to use
When you edit a page corresponding to each template, such as the header or footer, the body text will appear in the corresponding position.
For example, if it is a header, a page titled byakuraitmp_heder is generated, so please edit that page.
If there is a non-positional character, such as single, after the byakuraitmp, it means that the template will only be displayed for that page type.
For example, if you have changed the top page to a page, and you edit the page titled byakuraitmp_front_header, the body of the byakuraitmp_front_header will be displayed on the top page only instead of the body of the byakuraitmp_header.
If you want to display the same content in multiple templates, please use reusable blocks. A menu will also be added to the admin page that allows you to manage reusable blocks.

== Frequently asked question ==

The page for the template will appear in the appropriate section of the home page even if it is saved as a draft.

== Installation ==

　You can download and activate it from the Plug-ins menu in the administration screen, or upload the ZIP file and activate it.

== Screenshots ==

== Changelog ==

== Upgrade notice ==

