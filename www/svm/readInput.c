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
  char *str, *linetemp, *line, *label;
  int i,j,count;
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
  if ( inpfile )
  {
     line = (char *)malloc(STRMAXLEN*sizeof(char));
     i = 0;
     count=0;
     while( fgets( line, STRMAXLEN, inpfile ) )
     {
        linetemp = (char *)malloc(STRMAXLEN*sizeof(char));
        strcpy(linetemp, line);
	if (count == 0)
	  {
	    label=strtok(linetemp,"\n");
	    label=strtok(linetemp,"|");
	    label=strtok(NULL,"|");
	    /*printf("%s\n",label);*/
	    fprintf(labfile,"%s\n",label);
	    count = 1;
	  }
	else
	  {
	    /*printf("%s\n",linetemp);*/
	    string_replace(linetemp);
	    j = 0;
	    while (linetemp[j] != '\0')
	      {
		fprintf(opfile,"%c ",linetemp[j]);
		j++;
	      }
	      fprintf(opfile,"\n");
	    count = 0;
	  }
        free(linetemp);
        i++;
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
        if(*p1=='A' || *p1=='a')
        {
           *p1='1';
        }
        else if(*p1=='T' || *p1=='t')
        {
          *p1='2';
        }
        else if(*p1=='C' || *p1=='c')
        {
          *p1='3';
        }
        else if(*p1=='G' || *p1=='g')
        {
          *p1='4';
        }
        else if(*p1=='N' || *p1=='n')
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
