Cloud Controller
================

-- Early Development --

This is a abstraction from major cloud provider APIs allowing you to control services such as AWS, Google Cloud Compute
and Windows Azure from a common interface. The end result of this is that you could completely switch your entire
infrastructure integration simply by changing a provider name.

This library should cover all common components including compute resource (EC2, Google Cloud Compute, etc), load
balancing and object storage. Included in this should be all VPC, network, firewall, IP allocation and disk managment.


What Is Working
===============

Amazon Web Services
-------------------

### Instance Manager
* Create EC2 instances in multiple zones

### Object Store
* Put object
* Retrieve object
* Check if object exists
* Delete object


Google Cloud
------------

### Instance Manager
* Create EC2 instances in multiple zones
* Describe instances

Windows Azure
-------------

Planned.

