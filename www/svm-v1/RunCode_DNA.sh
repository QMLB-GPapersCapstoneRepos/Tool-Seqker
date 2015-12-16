#!/bin/bash 

#make clean
#make all

jobID= $1
nsamp= $2 #only for train.fasta, both dna and protein count total line count /2
ntest= $3 #only for test.fasta, both dna and protein count total line count /2
seqlen= $4  # protein put 11, DNA put 100

g=10
k=6
cval=10

trainfile=data/input/$jobID/$jobID.train.fasta   #argument required : file name
testfile=data/input/$jobID/$jobID.test.fasta   #argument required : file name
file=data/

#CONVERT TO DICTIONARY

DNA/./readInput $trainfile $file.TRAIN.LABELS.txt $file.TRAIN.SEQ.txt

DNA/./readInput $testfile $file.TEST.LABELS.txt $file.TEST.SEQ.txt

#CONCAT SEQUENCES TO FEED INTO GAPPED KERNEL

cat $file.TRAIN.SEQ.txt $file.TEST.SEQ.txt > $file.INPUT.SEQ.txt

#RUN GAPPED KERNEL

DNA/./gappedKernel_v2_fast $file.INPUT.SEQ.txt $g $k 5 $file.KERNEL.txt

#PREPARE TRAIN (tr*tr)  AND TEST KERNELS (ts*tr)

cat $file.KERNEL.txt|cut -d' ' -f1-$nsamp|head -$nsamp > $file.TRAIN.KERNEL.txt

cat $file.KERNEL.txt|cut -d' ' -f1-$nsamp|tail -$ntest > $file.TEST.KERNEL.txt


#ADD LABELS TO TRAIN AND VALID FILES

paste -d" "  $file.TRAIN.LABELS.txt $file.TRAIN.KERNEL.txt> $file.TRAIN.features.txt

paste -d" " $file.TEST.LABELS.txt $file.TEST.KERNEL.txt>$file.TEST.features.txt

#RUN SVMLIGHT

#TRAINING
	    
svmlight_ReadKernelV/./svm_learn -c $cval $file.TRAIN.features.txt $file.model.tmp

#TESTING

svmlight_ReadKernelV/./svm_classify -f 1 $file.TEST.features.txt $file.model.tmp $file.PRED.txt

#OUTPUT = $file.PRED.txt
