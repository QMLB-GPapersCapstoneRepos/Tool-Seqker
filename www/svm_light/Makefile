CC=gcc
CFLAGS=-O3 -ansi 

all:readInput gappedKernel_v2
readInput: shared.o readInput.o
gappedKernel_v2: shared.o gappedKernel_v2.o 
clean:	
	rm -f *.o readInput
	rm -f *.o gappedKernel_v2
