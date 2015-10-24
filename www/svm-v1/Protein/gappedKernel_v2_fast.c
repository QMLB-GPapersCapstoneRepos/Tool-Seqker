#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include "shared.h"

#define ARG_REQUIRED 5
#define MAX_NSTR 6000

int min(int a,int b)
{ return a < b ? a : b; }

Features *extractFeatures(int **S, int *len, int nStr, int g)
{
  int i, j, j1;
  int n, sumLen, nfeat;
  int *group;
  int *features;
  int *s;
  int c;
  Features *F;

  nfeat = 0;
  sumLen=0;
  
  for (i = 0; i < nStr; ++i)
  {
    sumLen+=len[i];
    nfeat += (len[i]>=g) ? (len[i]-g+1):0;
  }
  
  printf("numF=%d, sumLen=%d\n", nfeat, sumLen); /*checkpoint*/
  
  group = (int *)malloc(nfeat*sizeof(int));
  features = (int *)malloc(nfeat*g*sizeof(int *));
  c = 0;
  for (i = 0; i < nStr; ++i)
  {
    s = S[i];
    for (j = 0; j < len[i]-g+1; ++j)
    {
      for (j1=0; j1 <g; ++j1)
      {
        features[c+j1*nfeat]=s[j+j1];
      }
      group[c] = i;
      c++;
    }
  }
  if (nfeat!=c)
    printf("Something is wrong...\n");
    
  F = (Features *)malloc(sizeof(Features));
  (*F).features = features;
  (*F).group = group;
  (*F).n = nfeat;
  return F;
}


int main (int argc, char **argv)
{
  
  char *filename, *opfilename;
  int k, num_max_mismatches;
  int m,g;
  int na;
  int i, j, j1, j2, c, c1, c2, c3,x,y;
  unsigned int addr;
  int nStr,num_comb, value;
  int *w;
  int nfeat;
  double *K;
  unsigned int *nchoosekmat, *Ks, *Ksfinal, *Ksfinalmat;
  int *len;
  int **S;
  unsigned int *sortIdx;
  unsigned int *features_srt;
  unsigned int *group_srt;
  int *feat, *pos;
  unsigned int *feat1,*out, *out_temp,*resgroup;
  int *elems, *cnt_k;
  unsigned int *cnt_comb, *cnt_m;
  int maxIdx;
  char isVerbose;
  Features *features;
  Combinations *combinations;
  
  isVerbose = 0;
  if (argc != ARG_REQUIRED+1)
  {
    return help();
  }

  filename = argv[1];
  g = atoi(argv[2]);
  k = atoi(argv[3]);
  na = atoi(argv[4]);
  opfilename=argv[5];
  if (k <= 0 || g <= k || g>10 || g-k>6 || na <= 0)
    return help();
  len = (int *)malloc(MAXNSTR*sizeof(int));
  printf("Reading %s\n",filename);
  S = loadStrings(filename, len, &nStr);
  printf("Input file : %s\n",filename);
  printf("Read %d strings\n", nStr);/*checkpoint*/
  
  /* Precompute weights hm.*/
  w = (int *)malloc((g-k)*sizeof(int));
  for (i = 0; i <=g-k; i++)
  {
    w[i]=nchoosek(g-i,k);
  }

      
  /*Extract g-mers.*/
  features = extractFeatures(S,len,nStr,g);
  nfeat = (*features).n;
  feat = (*features).features;
  printf("(%d,%d): %d features\n", g, k, nfeat); /*checkpoint*/
  
  
  /*Compute gapped kernel.*/
  K = (double *)malloc(nStr*nStr*sizeof(double));
  
  addr=nfeat*nStr;
  Ksfinal = (unsigned int *)malloc(addr*sizeof(unsigned int));
  initalizeMatrix(Ksfinal, nfeat, nStr);
  
  elems=(int *)malloc(g*sizeof(int));

  feat1=(unsigned int *)malloc(nfeat*g*sizeof(unsigned int));
  initalizeMatrix(feat1, nfeat, g);
  
  pos=(int *)malloc(nfeat*sizeof(int));
  
  
  cnt_comb=(unsigned int *)malloc(2*sizeof(unsigned int));
  cnt_k=(int *)malloc(nfeat*sizeof(int));
  
  nchoosekmat=(unsigned int *)malloc(g*g*sizeof(unsigned int));
  initalizeMatrix(nchoosekmat,g,g); 
  
  for(i = g; i >= 0; --i)
  {
    for(j = 1; j <= i; ++j)
    {
      nchoosekmat[(i-1)+(j-1)*g]=nchoosek(i,j);
    }
  }
  
  combinations = (Combinations *)malloc(sizeof(Combinations));
  c=0;
  for (i = 0; i <= g-k; ++i)
  {

    (*combinations).n = g;
    (*combinations).k = g-i;
    (*combinations).num_comb = nchoosek(g,g-i);
    num_comb=nchoosek(g,g-i);
    addr=(nfeat*(num_comb+((*combinations).k*num_comb)))+nfeat;
    out=(unsigned int *)malloc(addr*sizeof(unsigned int));
    cnt_m=(unsigned int *)malloc(nfeat*sizeof(unsigned int));
    
    cnt_comb[0]=0;
    for(j1 = 0; j1 < nfeat; ++j1)
    {
      for(j2 = 0; j2 < g; ++j2)
      {
        elems[j2]=feat[j1+j2*nfeat];
      }
      getCombinations(elems,(*combinations).n,(*combinations).k,pos,0,0,cnt_comb,out,num_comb);
      
      cnt_m[j1]=cnt_comb[0];
      
      cnt_comb[0]=cnt_comb[0]+((*combinations).k*num_comb);
    }
   

    for(j = 0; j < num_comb; ++j)
    {
      for(j1 = 0; j1 < nfeat; ++j1)
      {
	for(j2 = 0; j2 <g-i; ++j2)
        {
          feat1[j1+j2*nfeat]=out[(cnt_m[j1]-num_comb+j)+j2*num_comb];
        }
      }
  
      sortIdx = (unsigned int *)malloc(nfeat*sizeof(unsigned int));
      sortIdx = cntsrtna(feat1,g-i,(*features).n,na);
       
      features_srt = (unsigned int *)malloc(nfeat*g*sizeof(unsigned int *));
      group_srt = (unsigned int *)malloc(nfeat*sizeof(unsigned int));
      for(j1 = 0; j1 < nfeat; ++j1)
      { 
        for (j2 = 0; j2 <g-i; ++j2)
        {
          features_srt[j1+j2*nfeat]=feat1[(sortIdx[j1])+j2*nfeat];
          group_srt[j1] = (*features).group[sortIdx[j1]];
        }
      }
      
      Ks = (unsigned int *)malloc(nStr*nStr*sizeof(unsigned int));
      initalizeMatrix(Ks,nStr,nStr);
     
      countAndUpdate(Ks,features_srt,group_srt,g-i,nfeat,nStr);
       
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          Ksfinal[(c+j1)+j2*nStr]=Ksfinal[(c+j1)+j2*nStr]+Ks[j1+j2*nStr];
        }
      }
      free(Ks); 
      free(sortIdx);
      free(features_srt);
      free(group_srt);
    }
    free(cnt_m);
    free(out);
    cnt_k[i]=c;    
    c=c+(nStr*nStr);
    printf("iter:%d\n",i);
  }
  
  c1=0;
  c2=0;
  
    num_max_mismatches=g-k;
    for (i = 1; i <= num_max_mismatches; ++i)
  {
    c1=cnt_k[i];
    for (j = 0; j <= i-1; ++j)
    {
      c2=cnt_k[j];
      for(j1 = 0; j1 < nStr; ++j1)
      {
        value=0;
        x=0;
        for(j2 = 0; j2 < nStr; ++j2)
        {
          Ksfinal[(c1+j1)+j2*nStr]=Ksfinal[(c1+j1)+j2*nStr]-nchoosekmat[(g-j-1)+(i-j-1)*g]*Ksfinal[(c2+j1)+j2*nStr];
        }
      }
    }
  }
    
  for (i = 0; i <= g-k; i++)
  {
      c1=cnt_k[i];
      
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          K[j1+j2*nStr]=K[j1+j2*nStr]+w[i]*Ksfinal[(c1+j1)+j2*nStr];
        }
      }
  }
  
  /*Normalize kernel values and write into a file*/
  FILE *kernelfile;
  kernelfile = fopen(opfilename, "w");
  for (i = 0; i < nStr; ++i)
  {
    for (j = 0; j < nStr; ++j)
    {
      fprintf(kernelfile, "%d:%e ", j+1,K[i+j*nStr]/sqrt(K[i+i*nStr]*K[j+j*nStr]));
    }
  fprintf(kernelfile,"\n");
  }
  fclose(kernelfile);

  free(feat1);
  free(elems);
  free(pos);
  free(cnt_comb);
  free(cnt_k);
  free(Ksfinal);
  free(K);
  free(combinations);
  free(w);
  free(nchoosekmat);
return 0;
}

int help()
{
  printf("Usage: gappedKernel <Sequence-file> <g> <k> <Alphabet-size> <Kernel-file>\n");
  printf("\t Sequence-file : file with sequence data\n");
  printf("\t g : length of gapped instance, >0 and <=10 \n");
  printf("\t k : length of k-mer, < g");
  printf("\t g-k <= 6");
  printf("\t Alphabet size, >0\n");
  printf("\t IMPORTANT: sequence elements must be\n\tin the range [0,AlphabetSize - 1].\n");
  return 1;
}
