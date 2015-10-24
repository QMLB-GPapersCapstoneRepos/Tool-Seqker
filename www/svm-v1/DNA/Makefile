CC=gcc
CFLAGS=-O3 -ansi

all:readInput gappedKernel_v2_fast
readInput: shared.o readInput.o
gappedKernel_v2_fast: shared.o gappedKernel_v2_fast.o -lm

clean:	
	rm -f *.o readInput
	rm -f *.o gappedKernel_v2_fast
