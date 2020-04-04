# KodExplorer Plugins
## 支持KodExplorer版本 v4.40 | [KodBox插件](https://github.com/zhtengw/kodexplorer-plugins/tree/v5.0)

### [OnlyOffice](https://github.com/zhtengw/kodexplorer-plugins/tree/master/OnlyOffice)
在线编辑office文档，此插件要求自己部署OnlyOffice文档服务器，可以使用docker快速部署：
```bash
docker pull onlyoffice/documentserver
docker run --name onlyoffice --restart always -i -t -d -p 8000:80 onlyoffice/documentserver  
```

### [毕升Office](https://github.com/zhtengw/kodexplorer-plugins/tree/master/bisheng)
在线编辑office文档，服务端部署方式请参考[毕升官方文档](https://www.bishengoffice.com/apps/blog/posts/install.html)。

### [PDFTron WebViewer](https://github.com/zhtengw/kodexplorer-plugins/tree/master/PDFTron)
在线阅读、批注PDF文档

### [draw.io](https://github.com/zhtengw/kodexplorer-plugins/tree/master/drawio)
在线图表编辑工具

### [Photopea](https://github.com/zhtengw/kodexplorer-plugins/tree/master/Photopea)
网页版PhotoShop，在线编辑图片，可查看编辑psd。

### [CADViewer](https://github.com/zhtengw/kodexplorer-plugins/tree/master/CADViewer)
使用sharecad.org在线查看CAD文件和3D模型。
