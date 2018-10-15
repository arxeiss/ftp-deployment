# FTP Deployment - Fork with custom edits

See original from David Grudl on [https://github.com/dg/ftp-deployment](https://github.com/dg/ftp-deployment)

---

To get own `*.phar` file, use command `php generatePhar`. Possible options are `--compress`, `--file=myDeployment.phar` and finally `--help`.

## Custom changes
Sometimes I want to add custom changes, which is not merged into original repo for any reason.<br>
Full documentation is available in the link above, here are only changes.

### 1. Show full CLI log
- I created [pull-request](https://github.com/dg/ftp-deployment/pull/111/files) which is not accepted (13.10.2018) for unknown reason
- To show full log also in CLI, not only in `*.log` file, add to config following line with possible values
- `yes` to disable shortening or list any of: `http`, `local`, `remote`, `upload`, `exception` with space as separator
- See commit [a685081a](https://github.com/arxeiss/ftp-deployment/commit/a685081af3a75c4281de143a88dfe76cc8333ef8)

```
fullCliLog = http exception
```
**Reason why I want this?**
Using FTP-Deployment with `after[]` action I run some Laravel commands (via routes or ssh). I want to show full output of those commands and not only first line.

### 2. Ignore "Already synchronized"
- This was many times requested feature, but never accepted [dg/ftp-deployment#104](dg/ftp-deployment/issues/104) and [dg/ftp-deployment#88](dg/ftp-deployment/issues/88).
- To run `before[]`, `afterUpload[]`, `purge[]`, `after[]` actions even not single file is changed add to config:
- See commit [0eeb721a](https://github.com/arxeiss/ftp-deployment/commit/0eeb721a55e568640626e03d48ca8f30118483ed)

```
alwaysRunActions = yes
```
**Reason why I want this?**
Using `after[]` I upload config files, which is normally ignored. Like DeployHQ does. I always want to upload config files, as they are not tracked with Git or FTP-Deployment. Example is in [article on my blog](http://www.kutac.cz/blog/weby-a-vse-okolo/nahravani-webu-pomoci-nastroje-ftp-deployment/) (Czech language only).

### 3. Ignore tracked files
- Another requested feature [dg/ftp-deployment/issues/20](https://github.com/dg/ftp-deployment/issues/20) which was rejected.
- Using `ignoreTracked` option it is possible to ignore some files or folders, which are already tracked. All data about those tracked files are kept in `.htdeployment`. So in the future after removing `ignoreTracked` it runs normally and sync all files.
- See commit [637a33ba](https://github.com/arxeiss/ftp-deployment/commit/637a33ba0d1c0f49171afa77a6d5d4f58608d20e)

```
ignoreTracked = "
    /vendor
    /another/temporary/ignored/folder
"
```

**Reason why I want this?**
Sometimes I want to do a quick deploy, but first I have to run `composer install --no-dev`, run deployment and run `composer install` which takes time. With this solution it is possible to ignore vendor folder, but keep those files tracked for future full deploy.