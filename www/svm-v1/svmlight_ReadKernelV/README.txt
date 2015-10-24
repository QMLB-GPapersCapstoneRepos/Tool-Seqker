

Sample running commands: 

>make 

> ./svm_learn -t 4 -c 2 ./testTmp/kernel-svmformat.txt ./testTmp/model.tmp

> ./svm_classify -f 1 ./testTmp/kernel-svmformat.txt ./testTmp/model.tmp ./testTmp/output.tmp
> ./svm_classify -f 0 ./testTmp/kernel-svmformat.txt ./testTmp/model.tmp ./testTmp/output.tmp


—————

Yanjun Qi @ March 21st / 2014 
Revised the original code from http://svmlight.joachims.org/

- kernel.h 

—————

Now expect the input data format as: 
-1 1:30037 2:906 3:528 4:354 #1

+ Format the kernel vector for a sample instance into the original SVM format
+ plus “#XX” . Here “XX” means the index number of the current sample instance 

+ Example file: ./testTmp/kernel-svmformat.txt
 
—————

