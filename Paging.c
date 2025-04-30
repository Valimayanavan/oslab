#include<stdio.h>

#include<math.h>

void main() {

 int size, n, pgno, pagetable[3] = {5, 6, 7}, i, j, frameno;

 double ml;

 int ra = 0, ofs;

 // Read process size

 printf("Enter process size (in KB of max 12KB): ");

 scanf("%d", &size);

 // Calculate number of pages required

 ml = size / 4;

 n = ceil(ml);

 printf("Total No. of pages: %d\n", n);

 // Read relative address in hexadecimal format

 printf("\nEnter relative address (in hexa): ");

 scanf("%x", &ra);

 // Calculate page number and offset

 pgno = ra / 1000;

 ofs = ra % 1000;
printf("Page no = %d\n", pgno);

 // Display page table

 printf("Page table:\n");

 for(i = 0; i < n; i++) {

 printf("%d[%d]\n", i, pagetable[i]);

 }

 // Get frame number from page table

 frameno = pagetable[pgno];

 // Calculate physical address and display it

 printf("\nPhysical address: %d%d\n", frameno, ofs);

}

OU
