#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include "shared.h"

#define ARG_REQUIRED 5


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
    /*printf("len[i]=%d\n",len[i]); //checkpoint*/
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
        /*printf("%d\t",features[c+j1*nfeat]); //checkpoint*/
      }
      /*printf("\n");*/
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
  int i, j, j1, j2, c, c1, c2,x;
  int nStr,num_comb, value;
  int *w;
  int nfeat;
  float *K;
  int *nchoosekmat, *Ks, *Ksfinal, *Ksfinalmat;
  int *len;
  int **S;
  int *sortIdx;
  int *features_srt;
  int *group_srt;
  int *feat, *feat1, *pos,*out,*resgroup;
  int *cnt_comb, *elems, *cnt_k, *cnt_m;
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
  if (k <= 0 || g <= k || na <= 0)
    return help();
  len = (int *)malloc(MAXNSTR*sizeof(int));
  printf("Reading %s\n",filename);
  S = loadStrings(filename, len, &nStr);
  printf("Input file : %s\n",filename);
  printf("Read %d strings\n", nStr);/*checkpoint*/
  
  /* Precompute weights hm.*/
  w = (int *)malloc((g-k)*sizeof(int));
  for (i = 0; i < g-k; i++)
  {
    w[i]=nchoosek(g-i,k);
  }

      
  /*Extract g-mers.*/
  features = extractFeatures(S,len,nStr,g);
  nfeat = (*features).n;
  feat = (*features).features;
  printf("(%d,%d): %d features\n", g, k, nfeat); /*checkpoint*/
  
  
  /*Compute gapped kernel.*/
  K = (float *)malloc(nStr*nStr*sizeof(float));
  /*initalizeMatrix(K, nStr, nStr);*/

  Ksfinal = (int *)malloc(nfeat*nStr*sizeof(int));
  initalizeMatrix(Ksfinal, nfeat, nStr);
  
  elems=(int *)malloc(g*sizeof(int));

  feat1=(int *)malloc(nfeat*g*sizeof(int));
  initalizeMatrix(feat1, nfeat, g);
  
  pos=(int *)malloc(nfeat*sizeof(int));
  
  
  cnt_comb=(int *)malloc(2*sizeof(int));
  cnt_k=(int *)malloc(nfeat*sizeof(int));
  cnt_m=(int *)malloc(nfeat*sizeof(int));
  
  nchoosekmat=(int *)malloc(g*g*sizeof(int));
  initalizeMatrix(nchoosekmat,g,g); 
  
  for(i = g; i >= 1; --i)
  {
    for(j = 1; j <= i; ++j)
    {
      nchoosekmat[(i-1)+(j-1)*g]=nchoosek(i,j);
    }
  }
  
  
  /*
  for(i = 0; i < g; ++i)
  {
    for(j = 0; j < g; ++j)
    {
      printf("%d\t",nchoosekmat[i+j*g]);
    }
  printf("\n");
  }
  
  */
  
  combinations = (Combinations *)malloc(sizeof(Combinations));
  c=0;
  
  for (i = 0; i < g-k; ++i)
  {
    
    (*combinations).n = g;
    (*combinations).k = g-i;
    (*combinations).num_comb = nchoosek(g,g-i);
    num_comb=nchoosek(g,g-i);
    out=(int *)malloc((nfeat*num_comb)*g*sizeof(int));
    /*out=(int *)malloc(num_comb*g*sizeof(int));*/
    
    for(j = 0; j < num_comb; ++j)
    {
      /*(*combinations).comb = (int *)malloc(nfeat*g*sizeof(int));*/
      
      cnt_comb[0]=0;
      for(j1 = 0; j1 < nfeat; ++j1)
      {
        
        for(j2 = 0; j2 < g; ++j2)
        {
          elems[j2]=feat[j1+j2*nfeat];
        }

        getCombinations(elems,(*combinations).n,(*combinations).k,pos,0,0,cnt_comb,out,(*combinations).num_comb);

        for(j2 = 0; j2 < g-i; ++j2)
        {
          feat1[j1+j2*nfeat]=out[(cnt_comb[0]-num_comb+j)+j2*num_comb];
          /*printf("%d\t",feat1[j1+j2*nfeat]); //checkpoint*/
        }
        
	/*printf("\n");*/
      }
    
      /*printf("----------------------------------------\n");*/
      
    
      printf("Combinations calculated.\n"); /*checkpoint*/
      sortIdx = (int *)malloc(nfeat*sizeof(int));
      sortIdx = cntsrtna(feat1,g-i,(*features).n,na);
      printf("Sorting done.\n"); /*checkpoint*/
    
    
      features_srt = (int *)malloc(nfeat*g*sizeof(int *));
      group_srt = (int *)malloc(nfeat*sizeof(int));
      for(j1 = 0; j1 < nfeat; ++j1)
      { 
        for (j2 = 0; j2 < g-i; ++j2)
        {
          features_srt[j1+j2*nfeat]=feat1[(sortIdx[j1])+j2*nfeat];
          group_srt[j1] = (*features).group[sortIdx[j1]];
          /*printf("%d\t",features_srt[j1+j2*nfeat]); //checkpoint*/
        }
	/*printf("\n");*/
      
      }
      /*printf("----------------------------------------\n");*/
      Ks = (int *)malloc(nStr*nStr*sizeof(int));
      initalizeMatrix(Ks,nStr,nStr);
      
      countAndUpdate(Ks,features_srt,group_srt,g-i,nfeat,nStr);
      
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          Ksfinal[(c+j1)+j2*nStr]=Ksfinal[(c+j1)+j2*nStr]+Ks[j1+j2*nStr];
          
          /*printf("%d\t",Ksfinal[(c+j1)+j2*nStr]);//checkpoint*/
        }
	/*printf("\n");*/
      }
      /*printf("------------------------------------------\n");*/
      
      free(Ks);
      
      
    
    }
    cnt_k[i]=c;    
    c=c+(nStr*nStr);
    printf("iter:%d\n",i);
    
  }
  
  
      free(out);
  
      /*  
//checkpoint

  for (i = 0; i < g-k; ++i)
  {
      c1=cnt_k[i];
      //printf("COUNT=%d\n",c1);
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          //printf("%d\t",(c1+j1)+j2*nStr);
        }
        //printf("\n");
      }
    //printf("-----------------\n");
  }
      */
  
  c1=0;
  c2=0;
  
  num_max_mismatches=g-k-1;
  for (i = 1; i < num_max_mismatches; ++i)
  {
    c1=cnt_k[i];
    /*printf("c1=%d\n",c1);*/
    for (j = 0; j <= i-1; ++j)
    {
      c2=cnt_k[j];
      /*printf("c2=%d\n",c2);*/
      for(j1 = 0; j1 < nStr; ++j1)
      {
        value=0;
        x=0;
        for(j2 = 0; j2 < nStr; ++j2)
        {
          Ksfinal[(c1+j1)+j2*nStr]=Ksfinal[(c1+j1)+j2*nStr]-nchoosekmat[(g-j-1)+(i-j-1)*g]*Ksfinal[(c2+j1)+j2*nStr];
          /*printf("%d\t",Ksfinal[(c1+j1)+j2*nStr]);*/
        }
	/*printf("\n");*/
      }
      /*printf("%d\t",Ksfinal[(c1+j1)+j2*nStr]);*/
    }
    /*printf("\n");*/
  }
  
  /*
  //checkpoint
  for (i = 0; i <= min(2*m,k); ++i)
  {
      c1=cnt_k[i];
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          //Ksfinal[(c1+j1)+j2*nStr]=Ksfinal[(c1+j1)+j2*nStr]-Ksfinalmat[(c1+j1)+j2*nStr];
          //printf("%d\t",Ksfinal[(c1+j1)+j2*nStr]);
        }
        //printf("\n");
      }
    //printf("-----------------\n");
  }

  */
  

  /*
  //----------------- test code starts -----------------------------//

  
  if(num_max_mismatches==k)
  {
    c1=cnt_k[k];
    printf("i,k=%d,%d\n",i,k);
    for(j1 = 0; j1 < nStr; ++j1)
    {
      for(j2 = 0; j2 < nStr; ++j2)
      {
        Ksfinal[(c1+j1)+j2*nStr]=(nfeat/2)*(nfeat/2);
        printf("%d\t",Ksfinal[(c1+j1)+j2*nStr]);
        c1++;
      }
      printf("\n");
    }
  }

     
 //----------------- test code ends-----------------------------//
 
 */
  for (i = 0; i < g-k; i++)
  {
      c1=cnt_k[i];
      
      for(j1 = 0; j1 < nStr; ++j1)
      {
        for(j2 = 0; j2 < nStr; ++j2)
        {
          K[j1+j2*nStr]=K[j1+j2*nStr]+w[i]*Ksfinal[(c1+j1)+j2*nStr];
          /*printf("%d\t",Ksfinal[(c1+j1)+j2*nStr]);*/
        }
        /*printf("\n");*/
      }
      /*printf("-------------------------------------------------------------------------------------\n");*/
  }
  
  FILE *kernelfile;
  kernelfile = fopen(opfilename, "w");
  for (i = 0; i < nStr; ++i)
  {
    for (j = 0; j < nStr; ++j)
    {
      fprintf(kernelfile, "%d:%f ", j+1,K[i+j*nStr]/K[i+i*nStr]);
    }
  fprintf(kernelfile,"\n");
  }
  fclose(kernelfile);

  free(feat1);
  free(elems);
  free(pos);
  free(sortIdx);
  free(features_srt);
  free(group_srt);
  free(cnt_comb);
  free(cnt_k);
  free(Ksfinal);
  free(combinations);
  free(w);
  
  /*-----------------------till here code o/p matches that of matlab version-------------------------------//

  //----------------------------code runs smoothly till here ---------------------------------------------*/

return 0;
}
int help()
{
  printf("Usage: mismatchKernel <Sequence-file> <k> <m> <Alphabet-size> <Kernel-file>\n");
  printf("\t Sequence-file : file with sequence data\n");
  printf("\t k : kernel parameter, >0 (size of k-mer)\n");
  printf("\t m : number of allower mismatches, <(k+1)/2\n");
  printf("\t Alphabet size, >0\n");
  printf("\t IMPORTANT: sequence elements must be\n\tin the range [0,AlphabetSize - 1].\n");
  return 1;
}
