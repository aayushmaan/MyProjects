from abc import *

class Employee(metaclass = ABCMeta):
    
    @abstractproperty
    def id_number(self):
        return 0
    '''
    @abstractproperty
    def name(self):
        return None
    
    @abstractproperty
    def salary(self):
        return 0
    '''
    
class HourlyEmployee(Employee):
    
    id=0
    
    def __init__(self,name=None,salary_perhour=0,hours=0):
        
        self._id=HourlyEmployee.id
        HourlyEmployee.id = HourlyEmployee.id + 1
        if not name:
            self._name = "{0}_{1}".format(self.__class__.__name__,self._id)
        else:
            self._name = name
        self._salary_perhour = salary_perhour
        self._hours = hours
        
        
    @property
    def id_number(self):
        return self._id
    
    @property
    def name(self):
        return self._name
    
    @name.setter
    def name(self,name):
        self._name = name
    
    @property
    def salary_perhour(self):
        return self._salary_perhour
    
    @salary_perhour.setter
    def salary_perhour(self,salary_perhour):
        self._salary_perhour = salary_perhour
    
    @property
    def hours(self):
        return self._hours
    
    @hours.setter
    def hours(self,hours):
        self._hours = hours
        
    @property
    def salary(self):
        return self._salary_perhour * self._hours
    
        
    def __repr__(self):
        return "{0}: {1}".format(self.__class__.__name__,self._id)
    
    def __str__(self):
        return "{name} receives {salary} for {hours}".format(name=self._name,salary=self._salary,hours=self._hours)


class SalariedEmployee(Employee):
    
    id=0
    
    def __init__(self,name=None,salary=0):
        
        self._id=SalariedEmployee.id
        SalariedEmployee.id = SalariedEmployee.id + 1
        if not name:
            self._name = "{0}_{1}".format(self.__class__.__name__,self._id)
        else:
            self._name = name
        self._salary = salary
        
        
    @property
    def id_number(self):
        return self._id
    
    @property
    def name(self):
        return self._name
    
    @name.setter
    def name(self,name):
        self._name = name
    
    @property
    def salary(self):
        return self._salary
    
    @salary.setter
    def salary(self,salary):
        self._salary = salary
        
    def __repr__(self):
        return "{0}: {1}".format(self.__class__.__name__,self._id)
    
    def __str__(self):
        return "{name} receives {salary}".format(name=self._name,salary=self._salary)

class Manager(Employee):
    
    id=0
    
    def __init__(self):
        self._id=Manager.id
        Manager.id = Manager.id + 1
        self._Employees = {}
        
    @property
    def id_number(self):
        return self._id
        
    @property
    def Employees(self):
        return self._Employees
    
    def Employees_add(self,*args):
        
        def add_to_Employees(emp):
            try:
                self._Employees[emp.name].append(emp)
            except:
                self._Employees[emp.name]= [emp]
                
            for arg in args:
                if isinstance(arg,tuple) or isinstance(arg,list):
                    for emp in arg:
                        add_to_Employees(emp)
                elif isinstance(arg,SalariedEmployee): # or isinstance(arg,HourlyEmployee):
                    add_to_Employees(arg)
        
    def __repr__(self):
        return "{0}: {1}".format(self.__class__.__name__,self._id)
    
    def __str__(self):
        return "{name} receives {salary}".format(name=self._name,salary=self._salary)
    
    
if __name__=="__main__":
    
    manager = Manager()
    
    genSEmp = lambda salary: SalariedEmployee(salary=salary)
    #genHEmp = lambda value: HourlyEmployee(salary_perhour=value,hours=value)
    
    for i in range(1,10):
        manager.Employees_add(genSEmp(salary=i))
    
        
    print(manager.Employees)
