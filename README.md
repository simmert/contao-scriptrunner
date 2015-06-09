# Contao Scriptrunner

A simple backend module to run custom scripts for administrative/maintenance purposes.

## How to use

Scriptrunner automatically detects PHP files within the script runner directory inside each extension. So if you want to provide your own script, create it inside **system/modules/your-ext/scriptrunner** and give it a telling name. The name of the file will be the name of the task in Scriptrunner’s backend module. The file needs to contain a class identical to the file’s name, exending \Contao\Backend and providing a public run() method without arguments. run() should return a String to display the result of the executed script to the Contao admin running the script. Do not namespace the class.

To run any of the detected scripts, use the backend module “Scriptrunner“ in the dev tools section of the Contao backend.

## Example

Let’s assume our extension is called “example“ and we want to provide a Scriptrunner script to update the timestamp of all tl_article records.

Create a script file called **system/modules/example/scriptrunner/UpdateTimestampsOfAllArticles.php** with the following content:

```php
<?php

class UpdateTimestampsOfAllArticles extends \Contao\Backend
{
    public function run()
    {
        $sql       = 'UPDATE tl_article SET tstamp=UNIX_TIMESTAMP()';
        $statement = $this->Database->prepare($sql);
        $result    = $statement->execute();

        return sprintf('Timestamps of %u articles updated.', $result->affectedRows);
    }
}
```
