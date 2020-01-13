# KodExplorer Plugins
## 支持KodExplorer版本 v4.40 | [KodBox插件](https://github.com/zhtengw/kodexplorer-plugins/tree/v5.0)

### OnlyOffice
在线编辑office文档，此插件要求自己部署OnlyOffice文档服务器，可以使用docker快速部署：
```bash
docker pull onlyoffice/documentserver
docker run --name onlyoffice --restart always -i -t -d -p 8000:80 onlyoffice/documentserver  
```

### 毕升Office
在线编辑office文档，服务端部署方式请参考[毕升官方文档](https://www.bishengoffice.com/apps/blog/posts/install.html)。

### draw.io
在线图表编辑工具

### Photopea
网页版PhotoShop，在线编辑图片，可查看编辑psd。

### CADViewer
使用sharecad.org在线查看CAD文件和3D模型。
