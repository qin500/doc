var o = new Object();//如果没有参数,可以省略后面括号

console.log(o.hasOwnProperty("name"))

// 操作符

// 一元操作符
var age = 29;
++age;
console.log(age)//30

var age = 29;
--age;
console.log(age)//28

var age = 29;
var anotherAge = --age + 2;
console.log(anotherAge)//30

var num1 = 2;
var num2 = 20;
var num3 = num1-- + num2;
var num4 = num1 + num2;
console.log(num3)//21
console.log(num4)//21

var num1 = "2";
var num2 = "z";
var num3 = false;
var num4 = 1.1;
var o = {
    valueOf() {
        return -1;
    }
}
console.log(++num1)//3
console.log(++num2)//NaN
console.log(++num3)//1
console.log(++num4)//2.1
console.log(++o)//0

var num = -18;
console.log(num.toString(2))

var num1 = 25;
var num2 = ~num1;
console.log(num2.toString(2))

var result = 25 & 3;
console.log(result)//1

var result = 25 | 3;
console.log(result)//27

var result = 25 ^ 3;
console.log(result)//26

//指数操作符
console.log(Math.pow(3, 2)); // 9
console.log(3 ** 2); // 9

//加法操作符
// 只有有一方为字符串,就返回为字符串
var num1 = 5;
var num2 = 10;
var message = "The sum of 5 and 10 is " + num1 + num2;
console.log(message); // "The sum of 5 and 10 is 510"

//关系操作符
console.log("abc" > "ADC")

console.log(null == undefined)
console.log(NaN == NaN)

var num = (5, 1, 4, 8, 0);
console.log(num)

//do while
