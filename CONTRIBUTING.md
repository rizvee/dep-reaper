# Contributing to DepReaper

First off, thank you for considering contributing to DepReaper! It's people like you that make DepReaper such a great tool.

## Where do I go from here?

If you've noticed a bug or have a suggestion, please open an issue describing the problem or the planned feature. If you want to contribute code, we welcome pull requests!

## Setting up your local environment

1. **Clone the repository:**
   ```bash
   git clone https://github.com/rizvee/dep-reaper.git
   cd dep-reaper
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Use the Makefile:**
   We strictly use `make` for our core commands:
   - `make check`: Runs static analysis (`phpstan`) and code styling checks (`phpcs`).
   - `make test`: Executes the PHPUnit test suite.
   - `make analyse`: Runs DepReaper on itself to ensure clean code.
   - `make build`: Compiles the PHAR file using Box.

## Opening a Pull Request

- Follow **Conventional Commits** for your PR titles and commit messages:
  - `feat(scope): ...`
  - `fix(scope): ...`
  - `docs(scope): ...`
  - `chore(scope): ...`
- Ensure all CI checks pass (`make check` and `make test`).
- Keep PRs focused on a single change or feature.

## Code of Conduct
Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms. Always be respectful and welcoming to other contributors.
