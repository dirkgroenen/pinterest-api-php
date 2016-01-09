### x.x.x (UNRELEASED)

- A lot of code cleanup based on Scruntinizer

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