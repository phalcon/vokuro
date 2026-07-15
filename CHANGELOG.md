# Changelog

All notable changes to `phalcon/vokuro` are documented here. The format is based on [Keep a Changelog][keep_a_changelog] and this project adheres to [Semantic Versioning][semantic_versioning].

## [5.0.4](https://github.com/phalcon/vokuro/releases/tag/v5.0.4) (2026-07-14)

### Added

- A `ControllerBase::flashForward()` helper that flashes a message and forwards to another action, replacing the repeated flash-and-forward blocks in the controllers.
- The `LoggerProvider` now registers the adapter from `debugbar` offering logging display directly in the debugbar

### Changed

- Typed properties, method parameters, and return values across the controllers, forms, models, providers, and plugins, and raised PHPStan analysis from level 1 to level 7.

### Removed

- Removed `exceptions` from the debugbar panel - handled separately now

## [5.0.3](https://github.com/phalcon/vokuro/releases/tag/v5.0.3) (2026-07-13)

### Added

- Integrated the Phalcon debug bar (`phalcon/debugbar`). A single events manager is registered as a shared service and handed to the database, view, router, and dispatcher providers; `DebugBarProvider` boots the bar against the application. The bar runs in development only, gated by `APP_ENV`.
- A `ControllerBase::flashForward()` helper that flashes a message and forwards to another action, replacing the repeated flash-and-forward blocks in the controllers.

### Changed

- Typed properties, method parameters, and return values across the controllers, forms, models, providers, and plugins, and raised PHPStan analysis from level 1 to level 7.

[keep_a_changelog]: https://keepachangelog.com/en/1.1.0/
[semantic_versioning]: https://semver.org/spec/v2.0.0.html
