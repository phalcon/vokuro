ALTER TABLE remember_tokens ALTER COLUMN "userAgent" TYPE text USING not null;

ALTER TABLE success_logins ALTER COLUMN "userAgent" TYPE text USING not null;

ALTER TABLE password_changes ALTER COLUMN "userAgent" TYPE text USING n+ot null;
