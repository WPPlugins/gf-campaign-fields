# Campaign Fields for Gravity Forms

Add custom field types to Gravity Forms that allow campaign data be stored with the form entry and be transmitted to 3rd party tools

## Description

This plugin adds advanced fields to Gravity Forms that collect campaign and device data and attaches the data to form entries.

The plugin can be configured to track first touch or last touch attribution and the campaign query string parameters are customizable.

The plugin currently supports:

* Google Analytics UTM Parameters
* Google AdWords (GCLID and MatchType)
* Device Information (browser, OS, device type)
* Marin (KWID and Creative ID)
* Google Analytics Client ID

## Installation

1. Upload the plugin files to the `/wp-content/plugins/gf-campaign-fields` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Forms->Settings->Campaign Info screen to configure the plugin

## Frequently Asked Questions

### Does this plugin include Gravity Forms?

No, you must purchase your own license of Gravity Forms


## Screenshots

1. The settings screen where you define first/last touch attribution and the query string parameters used to define the values
2. Building a form that contains campaign fields

## Changelog

### 2.1
* Refactored code to used GF_Field_HiddenGroup class
* Moved dependancies to "lib" folder
* Added Google Analytics Client ID field

### 2.0
* Added JS-Cookie library
* Refactored Campaign data storage
* Added config for Cookie Lifetime
* Improved first / last touch attribution capabilities
* Fixed WhichBrowser 500 error
* Added Google Tag Manger capabilities

### 1.1.6
* Configuration Error fix

### 1.1.5
* Fixed JS errors

### 1.1.0
* Fixed readme.txt format issues
* Fixed version inconsistencies

### 1.0
* The initial release.
