### 事件

| 名称         | 描述                       |
|------------|--------------------------|
| mouseout   | 鼠标移出                     |
| mousedown	 | 单击任意一个鼠标按钮时发生            |
| mouseout	  | 鼠标指针位于某个元素上且将要移出元素的边界时发生 |
| mouseover	 | 鼠标指针移出某个元素到另一个元素上时发生     |
| mouseup	   | 松开任意一个鼠标按钮时发生            |
| mousemove	 | 鼠标在某个元素上时持续发生            |

### 获取对象所有的属性

```javascript
//此方法不会返回从原型链继承的属性
const properties = Object.getOwnPropertyNames(document);
console.log(properties);
//此方法将返回document对象及其原型链中的所有属性名称。
for (const property in document) {
    console.log(property);
}
```

### 需要记住的属性

> className 获取或设置某个元素的class名称  
> tagName 获取某个元素的tag名称(document.querySelect("a").tagName)
>

### 信息框

> 三种对话框
> confirm , alert ,prompt

### 流程控制

> switch case  
> do while(),在条件为真之前至少执行一次

```javascript
 window.onload = initAll;

function initAll() {
    document.getElementById('Lincoln').onclick =
        document.getElementById('Kennedy').onclick =
            document.getElementById('Nixon').onclick = saySomething;
}

function saySomething() {
    switch (this.id) {
        case "Lincoln":
            alert("Four score and seven years ago...");
            break;
        case "Kennedy":
            alert("Ask not what your country can do for you...");
            break;
        case "Nixon":
            alert("I am not a crook!");
            break;
        default:
    }
}
```

### 异常处理

> try catch

### Math函数

| 函数             | 描述                    |
|----------------|-----------------------|
| abs            | 绝对值                   |
| sin、cos、tan    | 标准三角函数，参数用弧度表示        |
| acos、asin、atan | 反三角函数，返回值用弧度表示        |
| exp、log        | 以e为底数的指数和自然对数         |
| ceil           | 返回大于等于当前参数的最小整数       |
| floor          | 返回小于等于当前参数的最大整数       |
| min            | 返回两个参数中较小者            |
| max            | 返回两个参数中较大者            |
| pow            | 指数函数，第一个参数是底数，第二个参数是幂 |
| random         | 返回介于0和1之间的随机数         |
| round          | 返回当前参数最接近的整数，四舍五入     |
| sqrt           | 平方根                   |

### 探测对象

> 用于检查浏览器是否有能力理解你要使用的对象

```javascript
window.onload = initAll;

function initAll() {
    if (document.getElementById) {

    }
}
```

### 处理数组

> 数组可以包含任意类型数据:文本字符串,数字,其他javascript对象  
> 数组的写法  
> var newCars = new Array("Toyota", "Honda", "Nissan");

## 窗口

### 防止页面显示在框架中

```javascript
if (top.location != self.location) {
    top.location.replace(self.location);
}
```

