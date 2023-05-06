function sayHi(name, message) {
    console.log('Hello ' + name + ", " + message)
}

sayHi("小明", "今天星期几?")


function sum(num1, num2) {
    return num1 + num2;
    console.log('hello world')//不会被执行
}

const result = sum(5, 10)
console.log(result)

function sayHi(name, message) {
    return;
    console.log("Hello " + name + ", " + message); // 不会执行
}

console.log(sayHi())