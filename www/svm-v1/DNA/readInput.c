#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "shared.h"

#define ARG_REQUIRED 3

void string_replace (char *s);

int main (int argc, char **argv)
{
  char *filename, *labelfile, *seqfile;
  int **S;
  char *str, *linetemp, *line, *label,*seq, *conv, *conv1, *conv2, *conv3, *conv4;
  int i,j;
  FILE *inpfile, *labfile, *opfile;
  
    if (argc != ARG_REQUIRED+1)
  {
    return help2();
  }
  
  filename = argv[1];
  labelfile=argv[2];
  seqfile=argv[3];
  printf("Reading %s\n",filename);
  inpfile = fopen ( filename, "r" );
  labfile = fopen (labelfile, "w+");
  opfile = fopen (seqfile, "w+");
  i=0;
  if ( inpfile )
  {
     line = (char *)malloc(STRMAXLEN*sizeof(char));
     while( fgets( line, STRMAXLEN, inpfile ) )
     {
        linetemp = (char *)malloc(STRMAXLEN*sizeof(char));
        strcpy(linetemp, line);
        if(i==0)
	  {
	    seq=strtok(linetemp,"|");
	    label=strtok(NULL,"|");
	    fprintf(labfile,"%s",label);
	    i++;
	  }
	else
	  {
	    seq=linetemp;
	    string_replace(seq);
	    j = 0;
	    while (seq[j] != '\0')
	      {
		fprintf(opfile,"%c ",seq[j]);
		j++;
	      }
	    fprintf(opfile,"\n");
	    i=0;
	  }
	free(linetemp);
     }
     fclose(inpfile);
     fclose(labfile);
     fclose(opfile);
     free(line);
  }
  else
  {
    perror( filename );   
  }
}

void string_replace (char *s)
{
     char *p1;
 
     for(p1=s; *p1; p1++)
     {
        if(*p1=='A'||*p1=='a')
        {
           *p1='1';
        }
        else if(*p1=='C'||*p1=='c')
        {
          *p1='2';
        }
        else if(*p1=='T'||*p1=='t')
        {
          *p1='3';
        }
        else if(*p1=='G'||*p1=='g')
        {
          *p1='4';
        }
        else if(*p1=='N'||*p1=='n')
        {
          *p1='5';
        }
        else
        {
          *p1='6';
        }
     }
}

int help2()
{
  printf("Usage: readInput <Input-file> <Labels-file> <Sequence-file>\n");
  return 1;
}
