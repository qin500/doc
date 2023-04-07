# iframe窗口

```javascript
//判断当前是否被嵌入
if(self.location != top.self){
    document.location.replace(self.location)
}

//给iframe窗口添加内容
document.querySelector('iframe').contentWindow.document.body.innerHTML="<h1>你好,世界!</h1>";
```

### 相关函数
> parent  `parent.document.links`;  
> self 
