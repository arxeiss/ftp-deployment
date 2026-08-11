<?php declare(strict_types=1);

use Deployment\Deployer;
use Deployment\Helpers;
use Deployment\MockServer;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/MockServer.php';


// ignoreTrackedMasks must keep the matched file's hash in the persisted
// .htdeployment even though the file itself is never re-scanned/re-uploaded.
$localDir = TEMP_DIR . '/tracked/local';
mkdir($localDir, 0o777, true);
file_put_contents("$localDir/a.txt", 'new content A'); // changed -> triggers upload
file_put_contents("$localDir/b.txt", 'content B'); // unchanged, but tracked-ignored

$oldHashA = 'old_hash_a';
$hashB = Helpers::hashFile("$localDir/b.txt");

$server = new MockServer([
	'/.htdeployment' => Deployment\buildDeploymentData([
		'/a.txt' => $oldHashA,
		'/b.txt' => $hashB,
	]),
]);
$logger = new Deployment\Logger(TEMP_DIR . '/tracked.log');
$logger->showProgress = false;

$deployer = new Deployer($server, $localDir, $logger);
$deployer->tempDir = TEMP_DIR;
$deployer->ignoreTrackedMasks = ['b.txt'];
$deployer->deploy();

// b.txt must never be touched
Assert::same(['/a.txt'], $server->getUploadedPaths());

// but its hash must survive in the deployment file that actually landed on the server
$deployed = Deployment\decodeDeploymentFile($server);
Assert::true(isset($deployed['/b.txt']), '/b.txt hash must be preserved in .htdeployment');
Assert::same($hashB, $deployed['/b.txt']);
