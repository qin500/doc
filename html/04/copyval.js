//原始值
let num1 = 5;
let num2 = num1;

//引用值
var obj1 = {};
var obj2 = obj1;
obj1.name = "小明";
obj2.age = 30
console.log(obj1, obj2)


function addTen(num) {
    num += 10
    return num
}

let count = 20;
let result = addTen(count);
console.log(count);
console.log(result)


function setName(obj) {
    obj.name = "小明"
    obj = new Object()
    obj.name = "晓燕"
    console.log(obj)
}

let obj = new Object()
setName(obj)
console.log(obj.name)//小明





