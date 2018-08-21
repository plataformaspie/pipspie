x=100;
a=[];
for(i=0;i<(x*x);i++){if(!a[i/x|0]){a[i/x|0]=[]}a[i/x|0].push((i%x)==(i/x|0)?0:Math.random()>0.5?1:0)};
JSON.stringify(a);
// names from http://www.independent.co.uk/news/uk/home-news/baby-names-top-100-most-popular-boys-and-girls-names-10459074.html
// because I'm unimaginative!