

## About 

Create cpanel Backup and upload google drive 

## How setup
-- env file add cpanel username
-- cpanel main domain * without http or https*
-- cpanel API token * from cpanel*
-- DRIVE_BACKUP_FILE from Google *drivebackupload.json*
## Cron job setup
-- * * * * * php /path-to-your-laravel-project/artisan schedule:run >> /dev/null 2>&1

## setup google drive
1. Go to the Google Cloud Console
Visit the Google Cloud Console.
Log in with your Google account if required.
2. Create a Project (if you don’t have one)
In the top left corner, click the project dropdown.
Click New Project.
Name your project and click Create.
3. Enable the Required API
Go to the API & Services section.
Click on Library.
Search for the Google API you need (e.g., Google Cloud Storage, Cloud Vision API).
Click Enable on the API service page.
4. Create a Service Account
In the left-hand navigation, go to IAM & Admin -> Service Accounts.
Click + CREATE SERVICE ACCOUNT.
Enter a name for the service account (e.g., my-service-account) and optionally provide a description.
Click Create and Continue.
5. Assign Roles to the Service Account
Choose a role based on the permissions you need, such as:
Storage Admin for Google Cloud Storage.
Editor for broader access.
Click Continue.
6. Create and Download the JSON Key
Click + CREATE KEY.
Select JSON as the key type and click Create.
This will download a JSON file containing your credentials. 

