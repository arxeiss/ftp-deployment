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
```
fullCliLog = http exception
```
**Reason why I want this?**
Using FTP-Deployment with `after[]` action I run some Laravel commands (via routes or ssh). I want to show full output of those commands and not only first line.

### 2. Ignore "Already synchronized"
- This was many times requested feature, but never accepted [dg/ftp-deployment#104](dg/ftp-deployment/issues/104) and [dg/ftp-deployment#88](dg/ftp-deployment/issues/88).
- To run `before[]`, `afterUpload[]`, `purge[]`, `after[]` actions even not single file is changed add to config:

```
alwaysRunActions = yes
```
**Reason why I want this?**
Using `after[]` I upload config files, which is normally ignored. Like DeployHQ does. I always want to upload config files, as they are not tracked with Git or FTP-Deployment. Example is in [article on my blog](http://www.kutac.cz/blog/weby-a-vse-okolo/nahravani-webu-pomoci-nastroje-ftp-deployment/) (Czech language only).
