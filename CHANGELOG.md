### 0.2.13 (27-01-2020)
- Upgrade PHPunit and add tests for PHP 7.4
- Fix paths which return redirect errors [#106](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/106) [#107](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/107) [#108](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/108) [#109](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/109)

### 0.2.12 (14-06-2019
- Fix getRateLimitRemaining() issue [#100](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/100) [#99](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/99)
- drop testing support for <=7.0 [#97](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/97)
- Add note about Rate Limiting [#96](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/96)
- Add info about pagination property [#94](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/94)
- Fix instructions to match actual name [#93](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/93)
- Add sections [#95](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/95)

### 0.2.11 (10-05-2016)

- Add extra exception when response is empty [#45](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/45)
- Merge pull request [#43](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/43)
- Merge pull request [#46](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/46)
- Fix broken image upload [#47](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/47)

### 0.2.10 (11-02-2016)

- Fixed missing `http_build_query` in post requests [#39](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/39)

### 0.2.9 (10-02-2016)

- Add autoload.php as Composer alternative [#37](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/37)
- Add board update endpoint [#34](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/34)
- Fix patch requests
- Add `$field` to update requests

### 0.2.8 (02-02-2016)

- Fix Curl execFollow and error handling [#31](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/31)

### 0.2.7 (01-02-2016)

- Fix wrong variable name
[#30](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/30)

### 0.2.6 (01-02-2016)

- A lot of code cleanup based on Scruntinizer
- Added `original_url` attribute to Pin model [#24](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/24)
- Fixed typo in header [#27](https://github.com/dirkgroenen/Pinterest-API-PHP/pull/27)

### 0.2.5 (09-01-2016)

- Fixed disabling CURL safe_mode issue in PHP 7.0 [#21](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/21)

### 0.2.3 (03-01-2016)

- Add error codes to PinterestException ( [#17](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/17) )
- Remove `whoops` as dependency

### 0.2.2 (31-12-2015)

- Add error codes to PinterestException ( [#17](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/17) )

### 0.2.1 (23-12-2015)

- Add `setState` and `getState` methods ( [#15](https://github.com/dirkgroenen/Pinterest-API-PHP/issues/15) )

### 0.2.0 (18-12-2015)

- Changed default authentication response_type to `code` ( #4 / #7 / #14 )
- Fixed `getAccessToken()` path
- Added fallback for servers using open_basedir ( #9 )
