package org.wikimedia.lsearch.ranks;

import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;


/**
 * Page links object that has been optimized to use for low
 * memory consumption. String is being stored in a utf-8
 * encoded byte[] array, and the same object is to be used
 * as a key and value in a hashmap. 
 * 
 * Two objects equals iff they have the same string (other fields
 * are ignored in equals())
 * 
 * @author rainman
 *
 */
public class CompactArticleLinks{
	/** format: <ns>:<title> */
	protected byte[] str;
	public int links = 0;	
	protected int hash = 0;
	/** if this page is a redirect */
	public CompactArticleLinks redirectsTo = null;
	/** list of pages that redirect here */
	public CompactArticleLinks[] redirected = null;
	public int redirectedIndex = 0;
	/** list of pages that link to this page */
	public CompactArticleLinks[] linksIn = null;
	public int linksInIndex = 0;
	/** list of pages that this article links to */
	public CompactArticleLinks[] linksOut = null;
	public int linksOutIndex = 0;
	
	public CompactArticleLinks(String s){
		try {
			str = s.getBytes("utf-8");
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
	}
	
	public CompactArticleLinks(String s, int count){
		this(s);
		this.links = count;
	}		
	
	@Override
	public String toString() {
		try {
			return new String(str,0,str.length,"utf-8");
		} catch (UnsupportedEncodingException e) {
			return "";
		}
	}
		
	public String getKey(){
		try {
			return new String(str,0,str.length,"utf-8");
		} catch (UnsupportedEncodingException e) {
			return "";
		}
	}
	/** Add redirect to this page */
	public void addRedirect(CompactArticleLinks from){
		if(redirected == null)
			redirected = new CompactArticleLinks[2];
		if(redirectedIndex >= redirected.length){
			CompactArticleLinks[] nv = new CompactArticleLinks[redirected.length+2];
			System.arraycopy(redirected,0,nv,0,redirected.length);
			redirected = nv;
		}
		redirected[redirectedIndex++] = from;
	}
	/** add link to this article */
	public void addInLink(CompactArticleLinks from){
		if(linksIn == null)
			linksIn = new CompactArticleLinks[2];
		if(linksInIndex >= linksIn.length){
			CompactArticleLinks[] nv = new CompactArticleLinks[linksIn.length+10];
			System.arraycopy(linksIn,0,nv,0,linksIn.length);
			linksIn = nv;
		}
		linksIn[linksInIndex++] = from;
	}
	/** add link from this article */
	public void addOutLink(CompactArticleLinks to){
		if(linksOut == null)
			linksOut = new CompactArticleLinks[2];
		if(linksOutIndex >= linksOut.length){
			CompactArticleLinks[] nv = new CompactArticleLinks[linksOut.length+5];
			System.arraycopy(linksOut,0,nv,0,linksOut.length);
			linksOut = nv;
		}
		linksOut[linksOutIndex++] = to;
	}
	
	public boolean hasLinkFrom(CompactArticleLinks from){
		if(linksIn == null)
			return false;
		// use binary search, assumes linked is sorted
		int h = from.hashCode();
		int low = 0;
		int high = linksIn.length-1;

      while (low <= high) {
          int mid = (low + high) / 2;
          if (linksIn[mid].hashCode() > h)
              high = mid - 1;
          else if (linksIn[mid].hashCode() < h)
              low = mid + 1;
          else
              return true;
      }
      return false;
	}
	
	@Override
	public int hashCode() {
		int h = hash;
		if(h == 0){
			int off = 0;
			
			for (int i = 0; i < str.length; i++) {
				h = 31*h + str[off++];
			}
			hash = h;
		}
		
		return h;			
	}
	
	/** Sort by hash value to be able to more quickly find an object */
	public void sortLinked(){
		if(linksIn == null)
			return;
		ArrayList<CompactArticleLinks> l = new ArrayList<CompactArticleLinks>();
		for(int i=0;i<linksInIndex;i++)
			l.add(linksIn[i]);
		Collections.sort(l,new Comparator<CompactArticleLinks>() {
			public int compare(CompactArticleLinks o1, CompactArticleLinks o2){
				return o1.hashCode() - o2.hashCode();
			}
		});
		linksIn = l.toArray(new CompactArticleLinks[] {});
		linksInIndex = linksIn.length;
	}
	
	/** Delete any excessive space in linksIn, linksOut */
	public void compact(){
		CompactArticleLinks[] n;
		if(redirected != null && redirected.length != redirectedIndex){
			n = new CompactArticleLinks[redirectedIndex];
			System.arraycopy(redirected,0,n,0,redirectedIndex);
			redirected = n;
		}
		if(linksIn != null && linksIn.length != linksInIndex){
			n = new CompactArticleLinks[linksInIndex];
			System.arraycopy(linksIn,0,n,0,linksInIndex);
			linksIn = n;
		}
		if(linksOut != null && linksOut.length != linksOutIndex){
			n = new CompactArticleLinks[linksOutIndex];
			System.arraycopy(linksOut,0,n,0,linksOutIndex);
			linksOut = n;
		}
	}
	
	@Override
	public boolean equals(Object obj) {			
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		final CompactArticleLinks other = (CompactArticleLinks) obj;
		if(other.str.length != str.length)
			return false;
		for(int i=0;i<str.length;i++)
			if(str[i] != other.str[i])
				return false;
		return true;
	}
	
	
}