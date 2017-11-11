# Robo Google Lighthouse

Run Google Lighthouse commands from the Robo task runner.

### Prerequisites
- Install node `brew install node`
- Install lighthouse `npm install -g lighthouse`

### Getting Started

First, you'll need to download the Robo Google Lighthouse library using composer:

```bash
composer require droath/robo-google-lighthouse
```

### Example

Output an HTML file of the performance results. 

```php
<?php 
	use Droath\RoboGoogleLighthouse\Task\loadTasks;
   	
   $url = 'https://google.com';
   $path = '/tmp/example.html';
   $this->taskGoogleLighthouse()
        ->setUrl($url)
        ->performanceTestOnly()
        ->setOutputPath($path)
        ->run();
```

Output an JSON file of the results. 

```php
<?php 
	use Droath\RoboGoogleLighthouse\Task\loadTasks;
   	
   $url = 'https://google.com';
   $path = '/tmp/example.json';
   $this->taskGoogleLighthouse()
        ->setUrl($url)
        ->setOutput('json')
        ->setOutputPath($path)
        ->run();
```

### Support

The majority of the `lighthouse` commands available in the [CLI tool](https://github.com/GoogleChrome/lighthouse#using-programmatically) are supported.
If you find any discrepancies, please feel free to open up a GitHub issue.
