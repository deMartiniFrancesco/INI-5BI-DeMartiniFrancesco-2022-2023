# -*- coding: utf-8 -*-
__author__ = "Francesco"
__version__ = "0101 2022/10/29"

import os

head, tail = os.path.split(__file__)
os.chdir(head)
os.chdir("../..")
os.chdir(os.getcwd())

src_path = "src/main/java/deMartiniFrancesco/projects"


def list_directory():
    return [
        directory for directory in os.listdir(src_path)
        if os.path.isdir(src_path + "/" + directory)
    ]


boold = True
if __name__ == '__main__':
    if boold:
        print("Start")
    list_directory = list_directory()
    print(f'::set-output name=list_directory::{list_directory}')

    if boold:
        print("End")