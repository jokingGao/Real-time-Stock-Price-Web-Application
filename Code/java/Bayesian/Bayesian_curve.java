//package Bayesian;
import java.util.Scanner;
import java.util.Vector;
import java.util.Date;

import Jama.*;

public class Bayesian_curve {
	public static void main(String[] args) { 
		//input 10 csv
		 String[] com_name = {"google","yahoo","facebook","apple","microsoft","nvidia","amazon","tesla","sony","alibaba"};
		 String Post = "_historical.csv";
		 String Pre = "Stock/";
		 double[][] predict_price = new double[10][2];
		 //double[] actual_price = new double[10];
		 //String[] actual_date = new String[10];
		 //double[] absolute_error = new double[10];
		 //double[] relative_error = new double[10];
		 
		 //double average_absolute_error = 0;
		 //double average_relative_error = 0;
		 //Read file and get Data
		 System.out.println("CompanyName  PredictPrice  Date");
		 for(int i = 0; i < 10; i++){
					 MeanVariance mv = new MeanVariance();
					 String file_name = Pre + com_name[i] + Post;
					 ReadCSV fileread = new ReadCSV();
					 fileread.load(file_name);
					 double[] price;
					 String[] date;
					 //get price
					 price = fileread.getprice();
					 date = fileread.getdate();
					 //calculate price
					 predict_price[i] = mv.Calculate(price,10,1,date);
					 System.out.printf("%-13s",com_name[i]);
					 System.out.printf("%-13.2f %-13d\n",predict_price[i][0],1);

		 }

		 return;
	    } 	
}
	

