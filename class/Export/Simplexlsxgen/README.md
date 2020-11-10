# SimpleXLSXGen class 0.9.21 (Official)
[<img src="https://img.shields.io/endpoint.svg?url=https%3A%2F%2Fshieldsio-patreon.herokuapp.com%2Fshuchkin" />](https://www.patreon.com/shuchkin) [<img src="https://img.shields.io/github/license/shuchkin/simplexlsxgen" />](https://github.com/shuchkin/simplexlsxgen/blob/master/license.md) [<img src="https://img.shields.io/github/stars/shuchkin/simplexlsxgen" />](https://github.com/shuchkin/simplexlsxgen/stargazers) [<img src="https://img.shields.io/github/forks/shuchkin/simplexlsxgen" />](https://github.com/shuchkin/simplexlsxgen/network) [<img src="https://img.shields.io/github/issues/shuchkin/simplexlsxgen" />](https://github.com/shuchkin/simplexlsxgen/issues)

Export data to Excel XLSX file. PHP XLSX generator. No external tools and libraries.<br/>
(!) XLSX reader [here](https://github.com/shuchkin/simplexlsx).  

**Sergey Shuchkin** <sergey.shuchkin@gmail.com> 2020<br/>

*Hey, bro, please ★ the package for my motivation :)* 

## Basic Usage
```php
$books = [
    ['ISBN', 'title', 'author', 'publisher', 'ctry' ],
    [618260307, 'The Hobbit', 'J. R. R. Tolkien', 'Houghton Mifflin', 'USA'],
    [908606664, 'Slinky Malinki', 'Lynley Dodd', 'Mallinson Rendel', 'NZ']
];
$xlsx = SimpleXLSXGen::fromArray( $books );
$xlsx->saveAs('books.xlsx');
```
![XLSX screenshot](books.png)
```
// SimpleXLSXGen::download() or SimpleXSLSXGen::downloadAs('table.xlsx');
```

## Installation
The recommended way to install this library is [through Composer](https://getcomposer.org).
[New to Composer?](https://getcomposer.org/doc/00-intro.md)

This will install the latest supported version:
```bash
$ composer require shuchkin/simplexlsxgen
```
or download class [here](https://github.com/shuchkin/simplexlsxgen/blob/master/src/SimpleXLSXGen.php)

## Examples
### Data types
```php
$data = [
    ['Integer', 123],
    ['Float', 12.35],
    ['Procent', '12%'],
    ['Datetime', '2020-05-20 02:38:00'],
    ['Date','2020-05-20'],
    ['Time','02:38:00'],
    ['String', 'Long UTF-8 String in autoresized column'],
    ['Disable Type Detection', "\0".'2020-10-04 16:02:00']
];
SimpleXLSXGen::fromArray( $data )->saveAs('datatypes.xlsx');
```
![XLSX screenshot](datatypes.png)

### Debug
```php
ini_set('error_reporting', E_ALL );
ini_set('display_errors', 1 );

$data = [
    ['Debug', 123]
]
SimpleXLSXGen::fromArray( $data )->saveAs('debug.xlsx');
```


## History
v0.9.21 (2020-10-17) Updated images<br/>
v0.9.20 (2020-10-04) Disable type detection if string started with chr(0)<br/>
v0.9.19 (2020-08-23) Numbers like SKU right aligned now<br/>
v0.9.18 (2020-08-22) Fixed fast shared strings index<br/> 
v0.9.17 (2020-08-21) Fixed real numbers in 123.45 format detection, fast shared strings index (thx fredriksundin)<br/> 
v0.9.16 (2020-07-29) Fixed time detection in HH:MM:SS format<br/>
v0.9.15 (2020-07-14) escape of shared strings for special chars in cells [#1](https://github.com/shuchkin/simplexlsxgen/issues/1) <br/>
v0.9.14 (2020-05-31) fixed num2name A-Z,AA-AZ column names, thx Ertan Yusufoglu<br/>
v0.9.13 (2020-05-21) if string more 160 chars, save as inlineStr<br/>
v0.9.12 (2020-05-21) readme fixed<br/>
v0.9.11 (2020-05-21) removed XML unimportant attributes<br/>
v0.9.10 (2020-05-20) initial release