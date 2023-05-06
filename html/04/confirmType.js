//确定类型
let s = "aa"
let b = 11;
let i = true;
let u;
let n = null;
let o = new Object()


console.log(typeof s)
console.log(typeof b)
console.log(typeof i)
console.log(typeof u)
console.log(typeof n)
console.log(typeof o)

let students = new Array('彤彤', '小样', '李阳')
let persons = String("我是一个人")
console.log(students instanceof Array)
console.log(persons instanceof String)

function sum() {
}

console.log(sum instanceof Function) //true


