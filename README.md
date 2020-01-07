# KodExplorer Plugins
## 支持KodExplorer版本 v4.40

### OnlyOffice
在线编辑office文档，此插件要求自己部署OnlyOffice文档服务器，可以使用docker快速部署：
```bash
docker pull onlyoffice/documentserver
docker run --name onlyoffice --restart always -i -t -d -p 8000:80 onlyoffice/documentserver  
```

### Photopea
网页版PhotoShop，在线编辑图片，可查看编辑psd。

### CADViewer
使用sharecad.org在线查看CAD文件和3D模型。
