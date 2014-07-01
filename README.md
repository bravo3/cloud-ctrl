Cloud Controller
================

PHP 5.4 PSR compliant cloud infrastructure abstraction.

    -- Early Development --
    Contributions welcome! This project is an active prerequisite for a larger project.
    If you'd like to advance the development, shoot me a message to become a collaborator.

This is a abstraction from major cloud provider APIs allowing you to control services such as AWS, Google Cloud Compute
and Windows Azure from a common interface. The end result of this is that you could completely switch your entire
infrastructure integration simply by changing a provider name.

This library should cover all common components including compute resource (EC2, Google Cloud Compute, etc), load
balancing and object storage. Included in this should be all VPC, network, firewall, IP allocation and disk management.


What Is Working
===============

Amazon Web Services
-------------------

### Instance Manager
* Create EC2 instances in multiple zones
* Start, stop, restart, terminate instances
* Save, describe & delete images (AMIs)

### Object Store
* Put object
* Retrieve object
* Check if object exists
* Delete object


Google Cloud
------------

### Instance Manager
* Create compute instances in multiple zones
* Describe instances

Windows Azure
-------------

Planned.


