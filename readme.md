# FTP Deployment - Fork with custom edits

See original from David Grudl on [https://github.com/dg/ftp-deployment](https://github.com/dg/ftp-deployment)

---

## Custom changes
Sometimes I want to add custom changes, which is not merged into original repo for any reason.<br>
Full documentation is available in the link above, here are only changes.

### Ignore "Already synchronized"
- This was many times requested feature, but never accepted [dg/ftp-deployment#104](/dg/ftp-deployment/issues/104) and [dg/ftp-deployment#88](/dg/ftp-deployment/issues/88).
- To run `before[]`, `afterUpload[]`, `purge[]`, `after[]` actions even not single file is changed add to config:
- Reason why want this? Using `after[]` I upload config files, which is normally ignored. I always want to upload them, as they are not tracked with Git or FTP-Deployment. Example is in [article on my blog](http://www.kutac.cz/blog/weby-a-vse-okolo/nahravani-webu-pomoci-nastroje-ftp-deployment/) (Czech language only).

```
alwaysRunActions = yes
```