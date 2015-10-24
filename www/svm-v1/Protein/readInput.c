#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "shared.h"

#define ARG_REQUIRED 5
#define MAX_DICT_SIZE 100

/*global parameters*/
char alphabet[256];
int b;
int conv[256];

void readDictionary(char *dictfile);
void convertDictionary();

int main (int argc, char **argv)
{
  char *filename, *labelfile, *seqfile, *dictfile;
  int **S;
  int stringlen;
  char *str, *linetemp, *line, *label,*seq;
  int i,j;
  FILE *inpfile, *labfile, *opfile;
  
  
    if (argc != ARG_REQUIRED+1)
  {
    return help2();
  }
  dictfile=argv[1];
  filename = argv[2];
  labelfile=argv[3];
  seqfile=argv[4];
  stringlen=atoi(argv[5]);
  
  printf("Reading %s\n",dictfile);
  readDictionary(dictfile);
  convertDictionary();

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
        strcpy(linetemp,line);
        if(i==0)
	  {
	    label=strtok(linetemp,">");
	    fprintf(labfile,"%s",label);
	    i++;
	  }
	else
	  {
	    seq=linetemp;
	    seq[strlen(seq)-1]='\0';
	    for(j=0;j<stringlen;j++)
	      {
		if(seq[j]=='\0')
		  fprintf(opfile,"0 ");
		else
		  fprintf(opfile,"%d ",conv[toupper(seq[j])]);
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

void readDictionary(char *dictfile)
{
  FILE *inpfile;
  inpfile = fopen ( dictfile, "r" );
  char line[1000],linetemp[1000];
  char val;
  if ( inpfile )
  {
     b=0;
     while( fgets( line, STRMAXLEN, inpfile ) )
     {
       b++;
       val=line[0];
       alphabet[b]=val;
     }
     printf("Dictionary Size=%d\n",b);     
  }
  else
  {
    perror( dictfile );   
  }
	  
}

void convertDictionary()
{
  int i;
  
  for(i=0;i<b;i++)
    {
      conv[toupper(alphabet[i+1])]=i+1;      
    }

}



int help2()
{
  printf("Usage: readInput <Dict-file> <Input-file> <Labels-file> <Sequence-file>\n");
  return 1;
}
