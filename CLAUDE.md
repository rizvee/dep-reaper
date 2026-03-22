# DepReaper Developer Standards

## Commands
We have standardized the following scripts via the Makefile:
- `make check`: Run static analysis and linting.
- `make test`: Execute the PHPUnit test suite.
- `make analyse`: Run DepReaper on itself.

## Commit Guidelines
We enforce the Conventional Commits format for a professional `CHANGELOG.md`:
- `feat(scope): description`
- `fix(scope): description`
- `chore(scope): description`
- `docs(scope): description`
