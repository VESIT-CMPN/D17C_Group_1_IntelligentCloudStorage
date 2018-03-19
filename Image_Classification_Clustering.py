import shelve
try:
    from PIL import Image
except:
    print "please install PIL package"
    exit()
from os import listdir
import glob
import shutil
from os.path import isfile, join
from operator import itemgetter
from collections import Counter
from random import shuffle, randint, sample
import sys

# The environment class 
# takes input from user and passes on to the agent
# takes output from agent, does post-processing and returns output to user
class Environment:

    # initialize input
    def compute(self, image_path,mode):
        self.mode = mode
        try:
            self.mode = int(self.mode)
        except:
            print("\n Please enter a valid integer for your menu options")
            return

        # if classification of image chosen
        if self.mode == 1:
            #self.image_path = raw_input("Please enter image path:\n")
            self.image_path = image_path

            # checking if image path is valid
            try:
                im = Image.open(self.image_path)
            except:
                print "Image not found, please enter valid path"
                return
            im.close()
            #self.knn_k = raw_input("Please enter k value for k nearest neighbours:\n")
            self.knn_k = r'2'
            try:    
                self.knn_k = int(self.knn_k)
            except:
                print "Please enter valid integer value for k"
                return

            if self.knn_k == 0:
                print "K cannot be zero"
                return    
            
            self.comp_env()
        else:
        	print "Error"
    
   
    
    # The controller for Environment class
    # Takes input from user
    # sends percepts to the sensor 
    # Recieves output from actuator
    # Post processes and move file

    def comp_env(self):
        
        # To do KNN classification
        if self.mode ==1:
            agentIns =  Agent()
            agentIns.sensor(self.image_path,0,self.knn_k,self.mode)
            k_nearest_neighbours = agentIns.actuator()

            if len(k_nearest_neighbours) == 1:
                print "Your image is classified as "+k_nearest_neighbours[0][1]
            else:
                class_labels = []
                for value in k_nearest_neighbours:
                    class_labels.append(value[1])
                class_labels = Counter(class_labels).most_common(1)

                #print "Classification completed\n"
                #print "Your image is in the class of "+str(class_labels[0][0])+"\n"
                #print "moving"
                self.label = str(class_labels[0][0])
                #print self.label
                self.move()
                return
    
    def move(self):
        source = self.image_path
        BASE_PATH = "Images/"
        path = BASE_PATH + self.label
        shutil.move(source,path)

# Agent function Performs knn classification
class Agent:
    

    # sensors takes precept sequences from the environment and
    # sends them to the agent fuction
    def sensor(self,image_path, training_set, knn_k,mode):
        self.agentfunction(image_path, training_set, knn_k, mode)
    

    # Agent function processes percept sequences and produces a list of k nearest neighbours
    def agentfunction(self, image_path, training_set, knn_k, mode):
        self.knn_list = []
        if mode == 1:
            im = Image.open(image_path)
            im = im.resize((32,32))

            # Raw pixel Intensities
            raw_pixel_feature = []
            for featuretup in list(im.getdata()): 
                for feature in featuretup:
                    raw_pixel_feature.append(feature)

            
            lookup_shelve = shelve.open('lookuptable')
            

            for class_val in lookup_shelve.keys():            
                for feature_vector in lookup_shelve[class_val]:
                    self.knn_list.append([self.euclidean_distance(feature_vector[:-2],raw_pixel_feature), class_val])

            lookup_shelve.close()
        
        if mode == 3:
            
            for feature_vector in training_set:
                self.knn_list.append([self.euclidean_distance(feature_vector[:-2],image_path[:-2]), feature_vector[-2]])
            
        self.knn_list = sorted(self.knn_list, key=itemgetter(0))[:knn_k]

    # sends the k nearest neighbours list to the environment
    def actuator(self):
        return self.knn_list

    # calculates euclidean distance between feature vectors of input image and dataset    
    def euclidean_distance(self,feature_vector, raw_pixel_feature):
        dist = 0
        feature_vector = feature_vector[:-2]
        raw_pixel_feature = raw_pixel_feature[:-2]
        for i in range(len(feature_vector)):
            dist += (feature_vector[i]-raw_pixel_feature[i])**2
        return round(dist**0.5, 4)


env = Environment()
#image = r'C:\Users\tripa\Downloads\Image-Classification-and-clustering-master\datasets\headshots\th_093.jpg'
#env.compute(image,1)

files_jpg = glob.glob('mix/*.jpg')
files_png = glob.glob('mix/*.png')

files=[]
files.append(files_jpg)
files.append(files_png)

for i in range(len(files)):
    for j in range(len(files[i])):
        image = files[i][j]
        print image
        env.compute(image, 1)
