# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added
- Add `CHANGELOG`
- Add licence docs to `models`, `controllers`, `library`
- Add `squizlabs/php_codesniffer` and `travis`

### Changed
- Changed `userAgent` column type for `success_logins`, `password_changes` and `remember_tokens` tables to `TEXT` [#83](https://github.com/phalcon/vokuro/issues/83)

## [1.2.1] - 2018-02-08
### Changed
- Improved login verification
- Minor improvements and bugfixes

### Fixed
- Fixed and improved views
- Correct profile relation with permissions

## [1.2.0] - 2016-22-01
### Added
- Added logger

### Changed
- Cleanup code
- Don't show AWS' exception & warning at frontpage
- Increased PHP min. version

[Unreleased]: https://github.com/phalcon/vokuro/compare/v1.2.1...HEAD
[1.2.1]: https://github.com/phalcon/vokuro/compare/v1.2.0...v1.2.1
