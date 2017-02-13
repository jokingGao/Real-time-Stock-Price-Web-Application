//package Bayesian;

import java.io.BufferedReader;
import java.io.FileReader;


public class ReadCSV {
	private double[] price;
	private String[] date;
	public void load(String str){
		int count = 0;
		double[] price_data = new double[300];
		String[] date_data = new String[300];
		try {  
			//read from csv
            BufferedReader reader = new BufferedReader(new FileReader(str));
            String line = null;  
            while((line=reader.readLine())!=null && count<300){  
            	//csv file split by ,
                String item[] = line.split(",");
                String date = item[2];
                String price = item[4];
                //save the data from csv file
                double value = Double.parseDouble(price);
                price_data[count] = value;
                date_data[count] = date;
                count++;
            }  
        } catch (Exception e) {  
            e.printStackTrace();  
        }  
		//reverse the data
		int n = count - 1;
		price = new double[count];
		date = new String[count];
		for(int i = n; i >= 0; i--){
			price[n - i] = price_data[i];
			date[n - i] = date_data[i];
		}
	}
	//return price array
	public double[] getprice(){
		return price;
	}
	public String[] getdate(){
		return date;
	}
}



