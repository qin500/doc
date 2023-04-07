### 信息框
> 三种对话框
confirm , alert ,prompt

### 流程控制
> switch case 
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
|函数| 描述 |
|---|----|
|abs |绝对值|
|sin、cos、tan |标准三角函数，参数用弧度表示|
|acos、asin、atan |反三角函数，返回值用弧度表示|
|exp、log |以e为底数的指数和自然对数|
|ceil |返回大于等于当前参数的最小整数|
|floor |返回小于等于当前参数的最大整数|
|min |返回两个参数中较小者|
|max |返回两个参数中较大者|
|pow |指数函数，第一个参数是底数，第二个参数是幂|
|random |返回介于0和1之间的随机数|
|round |返回当前参数最接近的整数，四舍五入|
|sqrt |平方根|